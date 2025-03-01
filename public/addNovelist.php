<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: listNovelists.php");
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
    $novelistName = $_POST['novelist_name'];
    $novelistImage = $_POST['novelist_image'];
    $comment = $_POST['comment'];
    $books = $_POST['books'];
    $years = $_POST['years'];
    $novelistUrl = $_POST['novelist_url'];

    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 小説家データの取得
        $sql = "INSERT INTO novelist (novelist_name, novelist_image, comment, books, years, novelist_url) VALUES (:novelist_name, :novelist_image, :comment, :books, :years, :novelist_url)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':novelist_name', $novelistName);
        $stmt->bindParam(':novelist_image', $novelistImage);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':books', $books);
        $stmt->bindParam(':years', $years);
        $stmt->bindParam(':novelist_url', $novelistUrl);

        if ($stmt->execute()) {
            header("Location: listNovelists.php");
            exit;
        } else {
            $error = "追加に失敗しました。";
        }

        $dbh = null;
    } catch (PDOException $e) {
        $error = "データベース接続エラー: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>小説家追加</title>
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
            <h2 class="section-title">小説家追加</h2>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="novelist_name">名前:</label>
                    <input type="text" id="novelist_name" name="novelist_name" required>
                </div>
                <div class="form-group">
                    <label for="novelist_image">画像URL:</label>
                    <input type="text" id="novelist_image" name="novelist_image">
                </div>
                <div class="form-group">
                    <label for="comment">職業:</label>
                    <textarea id="comment" name="comment" rows="4" cols="50" required></textarea>
                </div>
                <div class="form-group">
                    <label for="books">著作:</label>
                    <input type="text" id="books" name="books">
                </div>
                <div class="form-group">
                    <label for="years">生涯:</label>
                    <input type="text" id="years" name="years">
                </div>
                <div class="form-group">
                    <label for="novelist_url">小説家URL:</label>
                    <input type="text" id="novelist_url" name="novelist_url">
                </div>
                <button type="submit" class="login-button">追加</button>
                <button type="button" onclick="history.back()" class="guest-button">戻る</button>
            </form>
            <?php endif; ?>
        </div>
    </main>
    <script src="assets/js/listbooks.js"></script>
</body>

</html>
