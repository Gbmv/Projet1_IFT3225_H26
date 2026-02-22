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
    public function displayBooks(int $page = 1)
    {
        // global variables
        global $pdo;
        global $dbname;

        // pagination configuration
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $total_results = 0;

        // retrives account id from active session
        $account_id = $this->account->getAccountIdFromActiveSession();

        if (!$account_id) return "No user logged";

        $query = 'SELECT book_id, title, author, category FROM `' . $dbname . '`.books WHERE account_id = :account_id LIMIT :limit OFFSET :offset';

        try {
            // bindvalue grants that limit and offset being treated as integer
            $res = $pdo->prepare($query);
            $res -> bindValue(':account_id', $account_id, PDO::PARAM_INT);
            $res -> bindValue(':limit', $limit, PDO::PARAM_INT);
            $res -> bindValue(':offset', $offset, PDO::PARAM_INT);
            $res->execute();
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }

        $book_cards = "";


        // execute loop to display books, while there are books being fetched from current user's book table
        while ($book = $res->fetch(PDO::FETCH_ASSOC)) {

            $bookId = (int)$book['book_id'];
            $title = htmlspecialchars($book['title'] ?? '');
            $author = htmlspecialchars($book['author'] ?? '');
            $category = htmlspecialchars($book['category'] ?? '');


            $book_cards .= <<<EOT
                <div class="col-12 col-md-3">
                        <div class="card h-100" style="background-color:#5A3422;">

                            <div class="card-header text-center">
                                <h4 style="color:#C9A24D; font-family:Georgia, serif;"> {$book['title']} </h4>
                            </div>

                            <img class="card-img-top" src=".\images\book_bg_2.png" alt="Card image">

                            <div class="card-body">
                                <p style="color: #F3E7D3"> {$book['author']} </p>
                                <h6 class="text-center" style="color:#C9A24D"> {$book['category']} </h6>
                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center" style="border-top-color:#8C4F2C">
                            <!-- EDIT button (goes to edit page) -->
                                <a class="btn" href="src/edit_book.php?book_id={$bookId}">
                                    <img src="./images/pencil.svg" class="img-fluid" style="width:30px;" alt="edit">
                                </a>

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
    // Updates a book (only if it belongs to the logged user)
    public function editBook(int $book_id, string $title, string $author, string $category): bool
    {
        global $pdo, $dbname;

        // trims strings to remove extra spaces
        $title = trim($title);
        $author = trim($author);
        $category = trim($category);

        // retrieves account id from current session
        $account_id = (int)$this->account->getAccountIdFromActiveSession();
        if (!$account_id) {
            throw new Exception("No user logged.");
        }

        if ($book_id <= 0) {
            throw new Exception("Invalid book id.");
        }

        // Update ONLY if this book belongs to this account
        $query = 'UPDATE `' . $dbname . '`.books
                SET title = :title, author = :author, category = :category
                WHERE book_id = :book_id AND account_id = :account_id';

        $values = array(
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':book_id' => $book_id,
            ':account_id' => $account_id
        );

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);

            // rowCount(): 1 se atualizou, 0 se não achou (ou dados iguais)
            return ($res->rowCount() > 0);

        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
    }
}
// teste
