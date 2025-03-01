<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: listbooks.php");
    exit;
}

// ログイン状態のチェック
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$userId = $loggedIn ? $_SESSION['user_id'] : null;

// データベースへの接続情報
$servername = "localhost";
$username = "readers";
$password = "password";
$dbname = "readers";

$error = '';

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookName = $_POST['book_name'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $years = $_POST['years'];
    $bookImage = $_POST['book_image'];
    $bookUrl = $_POST['book_url'];
    $comment = $_POST['comment'];

    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 書籍データの取得
        $sql = "INSERT INTO books (book_name, writer, genre, years, book_image, book_url, comment) VALUES (:book_name, :author, :genre, :years, :book_image, :book_url, :comment)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':book_name', $bookName);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':years', $years);
        $stmt->bindParam(':book_image', $bookImage);
        $stmt->bindParam(':book_url', $bookUrl);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            header("Location: listbooks.php");
            exit;
        } else {
            $error = "追加に失敗しました。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍追加</title>
    <link rel="stylesheet" href="assets/css/listbooks.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="assets/js/detail.js"></script>
</head>
<body>
    <?php
    define('ACCESS_ALLOWED', true);
    include('header.php');
    ?>

    <main>
        <div style="height: 10px;"></div>
        <div class="container">
            <h2 class="section-title">書籍追加</h2>
            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
                <form action="addbook.php" method="post">
                    <label for="book_name">書籍名</label>
                    <input type="text" id="book_name" name="book_name" required>

                    <label for="author">著者</label>
                    <input type="text" id="author" name="author" required>

                    <label for="genre">ジャンル</label>
                    <input type="text" id="genre" name="genre" required>

                    <label for="years">発行年</label>
                    <input type="text" id="years" name="years" required>

                    <label for="book_image">画像 URL</label>
                    <input type="text" id="book_image" name="book_image" required>

                    <label for="book_url">書籍 URL</label>
                    <input type="text" id="book_url" name="book_url" required>

                    <label for="comment">コメント</label>
                    <textarea id="comment" name="comment" rows="4" cols="50" required></textarea>

                    <button type="submit" class="login-button">追加</button>
                    <button onclick="history.back()" class="guest-button">戻る</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
