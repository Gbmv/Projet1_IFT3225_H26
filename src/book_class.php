<?php

include_once "db_inc.php";
require_once "account_class.php";

class Book
{

    // private class attributes
    private $title;
    private $author;
    private $category;
    private $book_id;
    private $account_id;
    private $book_card;

    // class will also contain account object so we can access its methods
    private $account;

    /* Public methods */


    // Constructor
    public function __construct(Account $account_obj)
    {
        $this->account = $account_obj;

        /* intializes the global variables to null */
        $this->title = NULL;
        $this->author = NULL;
        $this->category = NULL;
        $this->book_id = NULL;
        $this->account_id = NULL;
        $this->book_card = NULL;
    }

    public function __destruct() {}

    // Adds a book to the book table, returns book id
    public function addBook(string $title, string $author, string $category): int
    {
        global $pdo, $dbname;

        // trims strings to remove extra spaces
        $title = trim($title);
        $author = trim($author);

        // retrieves account id from current session, stores it into account_id
        $account = $this->account;
        $account_id = $account->getAccountIdFromActiveSession();

        // creates insert query
        $query = 'INSERT INTO `' . $dbname . '`.books(title, author, category, account_id) VALUES (:title, :author, :category, :account_id)';

        $values = array(':title' => $title, ':author' => $author, ':category' => $category, ':account_id' => $account_id);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
        // 
        return $pdo->lastInsertId();
    }

    // Deletes book from user's library
    public function deleteBook(string $book_id): bool
    {
        // global variables
        global $pdo;
        global $dbname;

        // delete book query template
        $query = 'DELETE FROM `' . $dbname . '`.books WHERE (book_id = :book_id)';

        // values array
        $values = array(':book_id' => $book_id);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
            echo "<p>Book deleted</p>";
            return true;
        } catch (PDOException $e) {
            throw new Exception('Database query error: ' . $e->getMessage());
        }
        return false;
    }


    // create user's books cards and display them all
    public function displayBooks()
    {
        // global variables
        global $pdo;
        global $dbname;

        // retrives account id from active session
        $account_id = $this->account->getAccountIdFromActiveSession();

        if (!$account_id) return "No user logged";

        $query = 'SELECT book_id, title, author, category FROM `' . $dbname . '`.books WHERE account_id = :account_id';
        $values = array(':account_id' => $account_id);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }

        $book_cards = "";

        // execute loop to display books, while there are books being fetched from current user's book table
        while ($book = $res->fetch(PDO::FETCH_ASSOC)) {
            $book_cards .= <<<EOT
                <div class="col-12 col-md-3">
                        <div class="card h-100" style="background-color:#5A3422;">
                            <div class="card-header text-center">
                                <h4 style="color:#C9A24D; font-family:Georgia, serif;"> {$book['title']} </h4>
                            </div>
                            <img class="card-img-top" src="./images/book_bg_2.png" alt="Card image">
                            <div class="card-body">
                                <p style="color: #F3E7D3"> {$book['author']} </p>
                                <h6 class="text-center" style="color:#C9A24D"> {$book['category']} </h6>
                            </div>
                            <div class="card-footer" style="border-top-color:#8C4F2C">
                               <form method = "POST" action = "src/delete_book.php">
                                    <input type="hidden" name="book_id" value="{$book['book_id']}">
                                    <button class="btn" type="submit">
                                        <img src="./images/delete_icon.svg" class="img-fluid" style="width:30px;" alt="remove">
                                    </button>
                                </form>
                            </div>  
                        </div>
                    </div>
EOT;
        }

        return $book_cards;
    }
}
// teste
