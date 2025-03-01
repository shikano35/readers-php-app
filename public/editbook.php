<?php
session_start();

// 管理者以外は書籍一覧にリダイレクト
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

// 書籍IDの取得
$bookId = $_GET['id'] ?? null;
$book = null;
$error = '';

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['book_id'];
    $bookName = $_POST['book_name'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $years = $_POST['years'];
    $comment = $_POST['comment'];
    $bookImage = $_POST['book_image'];
    $bookUrl = $_POST['book_url'];

    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 書籍データの更新
        $sql = "UPDATE books SET book_name = :book_name, writer = :author, genre = :genre, years = :years, comment = :comment, book_image = :book_image, book_url = :book_url WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':book_name', $bookName);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':years', $years);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':book_image', $bookImage);
        $stmt->bindParam(':book_url', $bookUrl);
        $stmt->bindParam(':id', $bookId);

        if ($stmt->execute()) {
            header("Location: listbooks.php");
            exit;
        } else {
            $error = "更新に失敗しました。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
} elseif ($bookId) {
    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 書籍データの取得
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $bookId);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$book) {
            $error = "書籍が見つかりません。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
} else {
    header("Location: listbooks.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍編集</title>
    <link rel="stylesheet" href="assets/css/listbooks.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="detail.js"></script>
</head>
<body>
    <?php
    define('ACCESS_ALLOWED', true);
    include('header.php');
    ?>

    <main>
        <div style="height: 10px;"></div>
        <div class="container">
            <h2 class="section-title">書籍編集</h2>
            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
                <form action="editbook.php" method="post">
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="book_name">書籍名</label>
                    <input type="text" id="book_name" name="book_name" value="<?php echo htmlspecialchars($book['book_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="author">著者</label>
                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['writer'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="genre">ジャンル</label>
                    <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="years">発行年</label>
                    <input type="text" id="years" name="years" value="<?php echo htmlspecialchars($book['years'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="comment">コメント</label>
                    <textarea id="comment" name="comment"  rows="4" cols="50" required><?php echo htmlspecialchars($book['comment'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    
                    <label for="book_image">画像 URL</label>
                    <input type="text" id="book_image" name="book_image" value="<?php echo htmlspecialchars($book['book_image'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="book_url">書籍 URL</label>
                    <input type="text" id="book_url" name="book_url" value="<?php echo htmlspecialchars($book['book_url'], ENT_QUOTES, 'UTF-8'); ?>" required>

                    <button type="submit" class="login-button">更新</button>
                </form>
            <?php endif; ?>
            <button onclick="location.href='listbooks.php'" class="guest-button">戻る</button>
        </div>
    </main>

    <script src="assets/js/listbooks.js"></script>
</body>
</html>
