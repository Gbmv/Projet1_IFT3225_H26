<?php 
// code inspiré par https://alexwebdevelop.com/user-authentication/

class Account
{
    // account's ID (null if it's not in db)
    private $id;
    // account's name (null if it's not in db)
    private $name;
    // returns true if user is authenticated and false if it's not
    private $authenticated;


    /*Public class methods */

    // Constructor
    public function __construct(Type $var = null) {
        /* intializes the global variables to null */
        $this->id = NULL;
        $this->name = NULL;
        $this->username = NULL;
        $this->authenticated = FALSE;
    }
    // Destructor
    public function __destruct(){

    }

    // Getter for $id 
    public function getId() : ?string{
        return $this->id;
    }

    /* Getter for $name */
    public function getName() : ?string{
        return $this->name;
    }

    /* Getter for $username */
    public function getUsername() : ?string{
        return $this->username;
    }

    /* Tell if user is authenticated, return true if yes, false if no */
    public function isAuthenticated(): bool{
        return $this->authenticated;
    }

    /* Adds a new account to the database and return it's ID */
    public function addAccount(string $name, string $password): int{

        // Global $pdo object
        global $pdo;
        global $schema;

        // trims strings to remove extra spaces
        $username = trim($username);
        $password = trim($password);
        $name = trim($name);

        /* Validation of user's infos */
        // checks if user username is valid
        if (!$this -> isUsernameValid($username)){
            throw new Exception('Invalid username');
        }
        // checks if user's password is valid
        if (!$this -> isPasswordValid($password)){
            throw new Exception('Invalid password');
        }

        // if id from the username doesn't exist, throws exception
        if (!is_null($this->getIdFromUsername($username))){
            throw new Exception('Username not available');
        }

        /*Adds new account */

        // creates insert query
        $query = 'INSERT INTO' . ' accounts(account_name, account_username, account_password) VALUES (:name, :username:, :password';

        // hash the password for user's protection
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // creates a 'values' array for PDO
        $values = array(':name' => $name, ':password'=>$hash);

        // executes the query
        try {
            $res = $pdo -> prepare($query);
            $res -> execute($value);

        } catch (PDOException $e) {
            // throw standard exception in case of a PDO exception
            throw new Exception("Database query error");
        } 
        // returns the new ID
        return $pdo->lastInsertId();
    }

    /* Deletes an account (selection by ID) */
    public function deleteAccount(string $id): bool {

        global $pdo;
        global $schema;

        // verification of id (is it valid?) 
        if (!$this->isIdValid($id)){
            throw new Exception('Invalid account ID');
        }

        // query DELETE template
        $query = 'DELETE FROM '. $schema . '.accounts WHERE (account_id =:id)';

        // values array for pdo
        $values = array(':id' => $id);

        // executes query
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

        // delete the sessions related to that account
        $query = 'DELETE FROM ' . $schema . '.account_sessions WHERE (account_id = :id)';

        /* Values array for PDO */
        $values = array(':id' => $id);
        
        /* Execute the query */
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return true;
    }

    /*Edits account */
    public function editAccount(){
        
    }

    /* Allows user to log in into his account, using his username and password*/
    public function login(string $username, string $password) : bool {
        global $pdo;
        global $schema;

        // Trim the strings //
        $name = trim($name);
        $passwd = trim($passwd);

        // checks if username is valid, if not, doesn't authenticate
        if (!$this->isUsernameValid($username)){
            return FALSE;
        }
        // checks password
        if (!$this->isPasswordValid($password)){
            return FALSE;
        }

        // selects account from in the db
        $query = 'SELECT * FROM' . $schema . '.accounts WHERE (account_username = :username)';

        // values array for PDO
        $values = array(':name' => $name);
        
        // execute the query
        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
           // If there is a PDO exception, throw a standard exception
           throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        // if there's a result, we check if password matches (we use password_verify())
        if (is_array($row)){
            if (password_verify($password, $row['account_password'])){

                // if authentification succeeds:
                $this->id = intval($row['account_id'], 10);
                $this->username = $username;
                $this->name = $name;
                $this->authenticated = TRUE;
                
                // register current login session in the db
                $this->registerLoginSession();

                return TRUE;
            }
        }

        // if authentication fails, return false
        return FALSE;
    }

    // checks for username sanitization
    public function isUsernameValid($string):bool{
        $valid = TRUE;
    
        // keeps the len of the username's string
        $len = strlen($username);

        // doesn't allow username smaller than 8 characters or larger than 16
        if (($len < 8) || ($len > 16)){
            $valid = FALSE;
        }
        return $valid;
    }

    // checks for password validity
    public function isPasswordValid(string $password):bool{
        $valid = TRUE;
        $len = strlen($password);
        // doesn't allow pwd smaller than 8 characters or larger than 16
        if (($len < 8) || ($len > 16)){
            $valid = FALSE;
        }
        return $valid;
    }
    
    // checks for password validity
    public function isIdValid(int $id):bool{
        $valid = TRUE;
        // doesn't allow pwd smaller than 8 characters or larger than 16
        if (($id < 1) || ($id > 1000)){
            $valid = FALSE;
        }
        return $valid;
    }
    
    // Login using sessions
    public function sessionLogin():bool {
        
        global $pdo;
        global $schema;

        // checks if session has been started
        if (session_status() == PHP_SESSION_ACTIVE)
        
        // TERMINAR
        
            {}
    }

    // gets id from user's name
    public function getIdFromName(string $name): ?int {
        
    }

}

?>