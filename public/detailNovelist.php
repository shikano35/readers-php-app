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

// 小説家IDの取得
if (isset($_GET['id'])) {
    $novelist_id = $_GET['id'];
} else {
    die("小説家IDが指定されていません。");
}

try {
    // データベースに接続
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 小説家データの取得
    $sql = "SELECT * FROM novelist WHERE id = :novelist_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':novelist_id', $novelist_id, PDO::PARAM_INT);
    $stmt->execute();

    // 小説家情報の取得
    if ($stmt->rowCount() > 0) {
        $novelist = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>小説家詳細</title>
    <link rel="stylesheet" href="assets/css/detail.css">
</head>
<body>
    <?php
    define('ACCESS_ALLOWED', true);
    include('header.php');
    ?>

    <div class="book-detail">
        <img src="<?php echo htmlspecialchars($novelist['novelist_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($novelist['novelist_name'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="book-info">
            <h2><?php echo htmlspecialchars($novelist['novelist_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <hr>
            <div class="book-comment"><?php echo htmlspecialchars($novelist['comment'], ENT_QUOTES, 'UTF-8'); ?></div>
            <p><strong>代表作:</strong> <span><?php echo htmlspecialchars($novelist['books'], ENT_QUOTES, 'UTF-8'); ?></span></p>
            <p><strong>生涯:</strong> <span><?php echo htmlspecialchars($novelist['years'], ENT_QUOTES, 'UTF-8'); ?></span></p>
            <div class="button-container">
                <a onclick="history.back()" class="back-button">戻る</a>
                <a href="<?php echo htmlspecialchars($novelist['novelist_url'], ENT_QUOTES, 'UTF-8'); ?>" class="read-button">詳細</a>
            </div>
        </div>
    </div>

    <script src="assets/js/detailNovelist.js"></script>
</body>
</html>

<?php
    } else {
        echo "小説家が見つかりませんでした。";
    }

    // データベース接続をクローズ
    $dbh = null;
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
}
?>
