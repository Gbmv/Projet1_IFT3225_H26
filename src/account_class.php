<?php
// code inspiré par https://alexwebdevelop.com/user-authentication/

class Account
{
    // account's ID (null if it's not in db)
    private $id;
    // account's name (null if it's not in db)
    private $name;
    // account's email (null if it's not in db)
    private $email;
    // returns true if user is authenticated and false if it's not
    private $authenticated;


    /*Public class methods */

    // Constructor
    public function __construct()
    {
        /* intializes the global variables to null */
        $this->id = NULL;
        $this->name = NULL;
        $this->email = NULL;
        $this->authenticated = FALSE;
    }
    // Destructor
    public function __destruct() {}

    // Getter for $id 
    public function getId(): ?string
    {
        return $this->id;
    }

    /* Getter for $email */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /* Tell if user is authenticated, return true if yes, false if no */
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }

    /* Adds a new account to the database and return it's ID */
    public function addAccount(string $email, string $password, string $name): int
    {

        // Global $pdo object
        global $pdo;
        global $schema;

        // trims strings to remove extra spaces
        $email = trim($email);
        $password = trim($password);
        $name = trim($name);

        /* Validation of user's infos */
        // checks if user email is valid
        if (!$this->isEmailValid($email)) {
            throw new Exception('Invalid email');
        }
        // checks if user's password is valid
        if (!$this->isPasswordValid($password)) {
            throw new Exception('Invalid password');
        }

        // if id from the email doesn't exist, throws exception
        if (!is_null($this->getIdFromEmail($email))) {
            throw new Exception("There's already an account with this email");
        }

        /*Adds new account */

        // creates insert query
        $query = 'INSERT INTO' . $schema . ' accounts(account_name, account_email, account_password) VALUES (:name, :email:, :password)';

        // hash the password for user's protection
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // creates a 'values' array for PDO
        $values = array(':email' => $email, ':password' => $hash);

        // executes the query
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            // throw standard exception in case of a PDO exception
            throw new Exception("Database query error");
        }
        // returns the new ID
        return $pdo->lastInsertId();
    }

    /* Deletes an account (selection by ID) */
    public function deleteAccount(string $id): bool
    {
        global $pdo;
        global $schema;

        // verification of id (is it valid?) 
        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid account ID');
        }

        // query DELETE template
        $query = 'DELETE FROM ' . $schema . '.accounts WHERE (account_id = :id)';

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
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return true;
    }

    /*Edits account */
    public function editAccount() {}

    /* Allows user to log in into his account, using his email and password*/
    public function login(string $email, string $password): bool
    {
        global $pdo;
        global $schema;

        // Trim the strings //
        $name = trim($email);
        $password = trim($password);

        // checks if email is valid, if not, doesn't authenticate
        if (!$this->isEmailValid($email)) {
            return FALSE;
        }
        // checks password
        if (!$this->isPasswordValid($password)) {
            return FALSE;
        }

        // selects account from in the db
        $query = 'SELECT * FROM' . $schema . '.accounts WHERE (account_email = :email)';

        // values array for PDO
        $values = array(':email' => $email);

        // execute the query
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            // If there is a PDO exception, throw a standard exception
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        // if there's a result, we check if password matches (we use password_verify())
        if (is_array($row)) {
            if (password_verify($password, $row['account_password'])) {

                // if authentification succeeds:
                $this->id = intval($row['account_id'], 10);
                $this->email = $email;
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

    // checks for email sanitization
    public function isEmailValid(string $email): bool
    {
        $valid = TRUE;

        // keeps the len of the email's string
        $len = strlen($email);

        // doesn't allow email smaller than 8 characters or larger than 16
        if (($len < 8) || ($len > 16)) {
            $valid = FALSE;
        }
        return $valid;
    }

    // checks for password validity
    public function isPasswordValid(string $password): bool
    {
        $valid = TRUE;
        $len = strlen($password);
        // doesn't allow pwd smaller than 8 characters or larger than 16
        if (($len < 8) || ($len > 16)) {
            $valid = FALSE;
        }
        return $valid;
    }

    // checks for password validity
    public function isIdValid(int $id): bool
    {
        $valid = TRUE;
        // doesn't allow pwd smaller than 8 characters or larger than 16
        if (($id < 1) || ($id > 1000)) {
            $valid = FALSE;
        }
        return $valid;
    }

    // Login using sessions
    public function sessionLogin(): bool
    {

        global $pdo;
        global $schema;

        // checks if session has been started
        if (session_status() == PHP_SESSION_ACTIVE) {
            // query: looks for current session id in the account_sessions table and make sure session's not older than 7 days 
            $query =
                'SELECT * FROM ' . $schema . '.account_sessions, ' . $schema . '.accounts WHERE (account_sessions.session_id =: sid)' .
                'AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = accounts.account_id)';

            // values array for pdo
            $values = array(':sid' => session_id());

            // executes the query
            try {
                $res = $pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                throw new Exception('Database query error');
            }

            $row = $res->fetch(PDO::FETCH_ASSOC);

            if (is_array($row)) {
                // retrieves accounts name, id and authenticates it
                $this->id = intval($row['account_id'], 10);
                $this->name = $row['account_name'];
                $this->authenticated = TRUE;

                return TRUE;
            }
        }
        // if authentification fails, return false
        return FALSE;
    }

    // Logs out current user
    public function logout()
    {

        global $pdo;
        global $schema;

        // if user's id is not found, do nothing
        if (is_null($this->id)) {
            return;
        }

        // reset account related properties
        $this->id = NULL;
        $this->name = NULL;
        $this->authenticated = FALSE;

        // closes active session, if there's one, removing it form account sessions table
        if (session_status() ==  PHP_SESSION_ACTIVE) {
            // delete query
            $query = 'DELET FROM ' . $schema . 'account_sessions WHERE (session_id = :sid)';

            $values = array(':sid' => session_id());

            try {
                // executes query
                $res = $pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                throw new Exception('DB query error');
            }
        }
    }

    // returns account id from user's $name, or NULL if not found
    public function getIdFromEmail(string $email): ?int
    {
        global $pdo;
        global $schema;

        // check for validity of email again
        if (!$this->isEmailValid($email)) {
            throw new Exception('Invalid email');
        }

        // initializes return value as null (in case no account is found)
        $id = NULL;

        // searches id on the db
        $query = 'SELECT account_id FROM ' . $schema . '.accounts WHERE (account_email = :email)';
        $values = array(':email' => $email);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (Exception $e) {
            throw new Exception("Database query error");
        }

        return $id;
    }

    // private method:

    // Saves the current session id with the account id
    private function registerLoginSession()
    {
        global $pdo;
        global $schema;

        if (session_status() == PHP_SESSION_ACTIVE) {

            // Replace will insert new row with session id if it doesnt exist, or update row with the session id if it exists
            $query = 'REPLACE INTO ' . $schema . '.account_sessions (session_id, account_id, login_time) VALUES (:sid, :accountId, NOW())';
            $values = array(':sid' => session_id(), ':accountId' => $this->id);

            try {
                $res = $pdo->prepare($query);
                $res->execute($values);                        
            } catch(PDOException $e){
                    throw new Exception("Database query error");
            }
        }
    }
}
