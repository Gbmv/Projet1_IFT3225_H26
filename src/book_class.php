<?php
require "db_inc.php";
require "account_class";

class Book
{

    // private class attributes
    private $title;
    private $author;
    private $category;
    private $book_id;
    private $account_id;
    private $book_card;

    /* Public methods */

    // Adds a book to the book table, returns book id
    public function addBook(string $title, string $author, string $category): int
    {
        global $pdo;
        global $dbname;

        // trims strings to remove extra spaces
        $title = trim($title);
        $author = trim($author);

        // retrieves account id from current session, stores it into account_id
        $account_id = $this->getAccountIdFromActiveSession();

        // creates insert query
        $query = 'INSERT INTO `' . $dbname . '`.books(title, author, category, account_id) VALUES (:title, :author, :category, :account_id)';

        $values = array(':title' => $title, ':author' => $author, 'category' => $category, 'account_id' => $account_id);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
        // 
        return $pdo->lastInsertId();
    }

    // 
    public function displayBooks()
    {
        // global variables
        global $pdo;
        global $dbname;

        // fazer loop que vai obter cada linha de livros de um usuario de tal id
        $account_id = $this->getAccountIdFromActiveSession();

        if (!$account_id) return "No user logged";

        $query = 'SELECT title, author, category FROM `' . $dbname . '`.books WHERE account_id = :account_id';
        $values = array(':account_id'=> $account_id);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
        
        $book_cards = "";

        // execute loop to display books, while there are books being fetched from current user's book table
        while ($book = $res->fetch(PDO::FETCH_ASSOC)) {
            $book_cards = <<<EOT
                <div class="col-12 col-md-3">
                        <div class="card h-100" style="background-color:#5A3422;">
                            <div class="card-header text-center">
                                <h4 style="color:#C9A24D; font-family:Georgia, serif;"> {$book['title']} </h4>
                            </div>
                            <img class="card-img-top" src="./images/book_bg_2.png" alt="Card image">
                            <div class="card-body">
                                <p style="color: #F3E7D3"> {$book['author']} </p>
                                <h6 class="text-center"> {$book['category']} </h6>
                            </div>
                            <div class="card-footer" style="border-top-color:#8C4F2C">
                                <button class="btn" type="button">
                                    <img src="./images/delete_icon.svg" class="img-fluid" style="width:30px;" alt="remove">
                                </button>
                            </div>  
                        </div>
                    </div>
            EOT;
        }

        return $book_cards;
    }

    // Returns account_id from account_sessions table (it will be used inside book's table)
    public function getAccountIdFromActiveSession(): ?int
    {
        global $pdo;
        global $dbname;

        // initializes the account_id as null, in case is not found
        $account_id = NULL;

        // retrieves session id
        $current_session_id = session_id();

        // selects accountId using sessionId
        $query = 'SELECT account_id FROM `' . $dbname . '`.account_sessions WHERE (session_id = :session_id)';
        // stores session id into an array (we take it back from db for security purposes)
        $values = array(':session_id' => $current_session_id);

        // prepares and execute query
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);

            $account_id = $res->fetch(PDO::FETCH_ASSOC);
            return $account_id['account_id'];
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
        // returns null if account_id doesnt exist
        return NULL;
    }
}
