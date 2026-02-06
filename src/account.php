<?php 

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

    // Getter for $name
    public function getName() : ?string{
        return $this->name;
    }

    // Getter for $username
    public function getUsername() : ?string{
        return $this->username;
    }

    // Tell if user is authenticated, return true if yes, false if no 
    public function isAuthenticated(): bool{
        return $this->authenticated;
    }

    // adds a new account to the database and return it's ID
    public function addAccount(string $name, string $password): int{

        // Global $pdo object
        global $pdo;
        global $bd;

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
        // checks if user's name is valid
        if (!$this -> isNameValid($name)){
            throw new Exception('Invalid name');
        }

        /*Adds new account */

        /***********IMPLEMENTAR O RESTO*********** ref: * */
        

        return $id;
    }

    //
    public function getIdFromName(string $name): ?int{

    }

}

?>