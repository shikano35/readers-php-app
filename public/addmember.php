<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: listmembers.php");
    exit;
}

// ログイン状態のチェック
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$userId = $loggedIn ? $_SESSION['user_id'] : null;

// データベースへの接続情報
$servername = "localhost";
$username_db = "readers";
$password_db = "password";
$dbname = "readers";

$error = '';

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $regDate = date('Y-m-d H:i:s');

    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username_db, $password_db);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 会員データの取得
        $sql = "INSERT INTO memberReaders (username, email, password, reg_date) VALUES (:username, :email, :password, :reg_date)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':reg_date', $regDate);

        if ($stmt->execute()) {
            header("Location: listmembers.php");
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
    <title>会員追加</title>
    <link rel="stylesheet" href="assets/css/listbooks.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <?php
    define('ACCESS_ALLOWED', true);
    include('header.php');
    ?>

    <main>
        <div style="height: 10px;"></div>
        <div class="container">
            <h2 class="section-title">会員追加</h2>
            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
                <form action="addmember.php" method="post">
                    <label for="username">ユーザー名</label>
                    <input type="text" id="username" name="username" required>

                    <label for="email">メール</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" class="login-button">追加</button>
                    <button onclick="history.back()" class="guest-button">戻る</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
    <script src="assets/js/listbooks.js"></script>
</body>
</html>
