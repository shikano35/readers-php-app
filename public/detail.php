<?php
session_start();

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
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
} else {
    die("書籍IDが指定されていません。");
}

try {
    // データベースに接続
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 書籍データを取得
    $sql = "SELECT * FROM books WHERE id = :book_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();

    // 書籍情報を取得
    if ($stmt->rowCount() > 0) {
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍詳細</title>
    <link rel="stylesheet" href="assets/css/detail.css">
</head>
<body>
    <?php
    define('ACCESS_ALLOWED', true);
    include('header.php');
    ?>

    <div class="book-detail">
        <img src="<?php echo htmlspecialchars($book['book_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($book['book_name'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="book-info">
            <h2><?php echo htmlspecialchars($book['book_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <hr>
            <div class="book-comment"><?php echo htmlspecialchars($book['comment'], ENT_QUOTES, 'UTF-8'); ?></div>
            <p><strong>著者:</strong> <span><?php echo htmlspecialchars($book['writer'], ENT_QUOTES, 'UTF-8'); ?></span></p>
            <p><strong>ジャンル:</strong> <span><?php echo htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8'); ?></span></p>
            <p><strong>出版年:</strong> <span><?php echo htmlspecialchars($book['years'], ENT_QUOTES, 'UTF-8'); ?></span></p>
            <div class="button-container">
                <a onclick="history.back()" class="back-button">戻る</a>
                <a href="<?php echo htmlspecialchars($book['book_url'], ENT_QUOTES, 'UTF-8'); ?>" class="read-button">読む</a>
            </div>
        </div>
    </div>

    <script src="assets/js/detail.js"></script>
</body>
</html>

<?php
    } else {
        echo "書籍が見つかりませんでした。";
    }

    // データベース接続をクローズ
    $dbh = null;
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
}
?>
