# Projet1_IFT3225_H26


---

# 📚 Personal Library – IFT3225 Project

## Project Overview

This project is a personal library web application developed for **IFT3225 (Winter 2026)**.

The application allows users to:

* Register an account
* Log in securely
* Manage a personal list of books they have already read
* Add, view, edit, and delete books

The system is built using PHP and MySQL and runs locally with MAMP.

---

## Team Members

* **Gabriel Viana**
* **Caio Torres**

### Task Distribution

**Caio**

* Website structure and layout
* User authentication (Register & Login)
* Page integration and navigation

**Gabriel**

* Book management features (CRUD logic)
* Database interaction using PDO
* Backend logic for book operations

---

## Technologies Used

* PHP
* MySQL / MariaDB
* PDO (PHP Data Objects)
* HTML
* CSS
* JavaScript
* MAMP (Apache + MySQL)

---

## Database Configuration

Database name:

```
tp1-ift3225
```

Default connection settings (db_inc.php):

* Host: localhost
* Username: root
* Password: (empty)
* Database: tp1-ift3225

Passwords are stored using hashing for security.

---

## How to Run the Project Locally (MAMP)

> MAMP must already be installed.

### 1. Place the Project Folder

Copy the project folder into:

```
MAMP/htdocs/
```

Example:

```
MAMP/htdocs/Projet1_IFT3225_H26/
```

---

### 2. Start MAMP

Ensure:

* Apache is running
* MySQL is running

---

### 3. Create the Database

1. Open phpMyAdmin (via MAMP)
2. Create a database named:

```
tp1-ift3225
```

3. Import the file:

```
tp1-ift3225.sql
```

---

### 4. Open the Application

In your browser, go to:

```
http://localhost/Projet1_IFT3225_H26/
```

(Adjust the folder name if necessary.)

---

## How to Test the Application

1. Register a new account
2. Log in
3. Add a new book
4. Verify it appears in the list
5. Edit or delete a book
6. Log out

---

## Deployment (DIRO Servers)

The application has also been deployed on the DIRO servers as required.

* URL: [Insert DIRO URL here]
* Transfer method: scp / sftp / rsync
* Database configuration may differ on the server

---

## Code References

Parts of the authentication system and UI were inspired by:

* [https://alexwebdevelop.com/user-authentication/](https://alexwebdevelop.com/user-authentication/)
* W3Schools examples (Bootstrap / PHP)

All code was adapted and integrated into our own implementation.


