<?php
// Debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/db_inc.php');
require_once(__DIR__ . '/account_class.php');
require_once(__DIR__ . '/book_class.php');
require_once(__DIR__ . '/sanitization.php');

session_start();

// Login required
$current_account = new Account();
if (!$current_account->sessionLogin()) {
    header('Location: login.php');
    exit;
}

global $pdo, $dbname;

// book_id from URL: edit_book.php?book_id=123
$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;
if ($book_id <= 0) {
    header('Location: ../home.php');
    exit;
}

$account_id = (int)$current_account->getAccountIdFromActiveSession();
if (!$account_id) {
    header('Location: login.php');
    exit;
}

// Helpers
function getBookByIdForAccount(PDO $pdo, string $dbname, int $book_id, int $account_id): ?array
{
    $query = 'SELECT book_id, title, author, category
              FROM `' . $dbname . '`.books
              WHERE book_id = :book_id AND account_id = :account_id
              LIMIT 1';

    $res = $pdo->prepare($query);
    $res->execute([
        ':book_id' => $book_id,
        ':account_id' => $account_id
    ]);

    $row = $res->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

// Load current book
$bookRow = getBookByIdForAccount($pdo, $dbname, $book_id, $account_id);
if (!$bookRow) {
    // book doesn't exist or doesn't belong to this user
    header('Location:  ../home.php');
    exit;
}

// Form state
$titleErr = $authorErr = $categoryErr = $msgErr = $success = "";
$title = $bookRow['title'];
$author = $bookRow['author'];
$category = $bookRow['category'];

$categories = [
    "" => "",
    "Action" => "Action",
    "Adventure" => "Adventure",
    "Romance" => "Romance",
    "Religion" => "Religions",
    "Horror" => "Horror",
    "Sciences" => "Sciences",
    "History" => "History",
    "Biography" => "Biography",
    "Fantasy" => "Fantasy",
    "SciFi" => "SciFi",
    "Philosophy" => "Philosophy",
    "Other" => "Other",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $valid = true;

    // sanitize
    $title = clean($_POST["title"] ?? "");
    $title = ucwords(trim($title));

    $author = clean($_POST["author"] ?? "");
    $author = ucwords(trim($author));

    $category = clean($_POST["categories"] ?? "");
    $category = trim($category);

    // validate
    if ($title === "") {
        $titleErr = '<div class="alert alert-danger" role="alert">Title required</div>';
        $valid = false;
    }
    if ($author === "") {
        $authorErr = '<div class="alert alert-danger" role="alert">Author required</div>';
        $valid = false;
    }
    if ($category === "" || !array_key_exists($category, $categories)) {
        $categoryErr = '<div class="alert alert-danger" role="alert">Valid category required</div>';
        $valid = false;
    }

    if ($valid) {
        try {
            $book = new Book($current_account);

            $ok = $book->editBook($book_id, $title, $author, $category);

            if ($ok) {
                header('Location: ../home.php');
                exit;
            } else {
                $msgErr = '<div class="alert alert-warning" role="alert">Nothing updated.</div>';
            }

        } catch (Exception $e) {
            $msgErr = '<div class="alert alert-danger" role="alert">' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-vh-100" style="background-color:#fff2df">
<nav class="navbar sticky-top" style="background-color:#2B1A12">
    <div class="container-fluid">
        <a class="navbar-brand text-decoration-none" href="../home.php" style="color:#C9A24D">
            ← Back
        </a>

        <div class="nav-item me-auto ms-3" style="color:#C9A24D">
            <p class="mb-0">Hey, <?php echo htmlspecialchars($current_account->getName() ?? ''); ?>!</p>
            <p class="mb-0"><?php echo htmlspecialchars($current_account->getEmail() ?? ''); ?></p>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 720px;">
    <div class="card shadow-sm" style="border-color:#C9A24D;">
        <div class="card-body">
            <h3 class="mb-4" style="font-family:Georgia, serif; color:#2B1A12;">Edit Book</h3>

            <?php
            echo $success;
            echo $msgErr;
            ?>

            <form method="POST" action="">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" name="title"
                           value="<?php echo htmlspecialchars($title); ?>" required>
                    <label for="title" style="font-family:Georgia, serif">Title</label>
                </div>
                <?php echo $titleErr; ?>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="author" name="author"
                           value="<?php echo htmlspecialchars($author); ?>" required>
                    <label for="author" style="font-family:Georgia, serif">Author</label>
                </div>
                <?php echo $authorErr; ?>

                <label class="form-label p-2" for="categories" style="font-family:'Georgia, serif'; color:#2B1A12">Category</label>
                <select class="form-select"
                        style="color:#2B1A12; background-color:#fff2df; border-color:#C9A24D; font-family:'Georgia, serif'"
                        name="categories" id="categories" required>
                    <?php foreach ($categories as $val => $label): ?>
                        <option value="<?php echo htmlspecialchars($val); ?>"
                            <?php echo ($category === $val) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php echo $categoryErr; ?>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn w-100"
                            type="submit"
                            style="background-color:#8C4F2C; color:#F3E7D3; border-color:#C9A24D; font-family:Georgia, serif">
                        Save changes
                    </button>

                    <a class="btn w-100"
                       href="../home.php"
                       style="border:1px solid #2B1A12; color:#2B1A12; font-family:Georgia, serif">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>