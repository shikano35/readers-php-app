<?php
session_start();

// データベースへの接続情報
$servername = "localhost";
$username = "readers";
$password_db = "password";
$dbname = "readers";

if (isset($_SESSION['user_id'])) {
    $error_message = "ログインしています。";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // データベースに接続
        $dsn = "mysql:dbname=$dbname;host=$servername;charset=utf8";
        $dbh = new PDO($dsn, $username, $password_db);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 管理者チェック
        if ($email === 'system@system' && $password === 'system') {
            $_SESSION['user_id'] = 'admin';
            $_SESSION['username'] = '管理者';
            $_SESSION['is_admin'] = true;
            header("Location: listbooks.php");
            exit;
        }

        // ユーザー情報を取得
        $stmt = $dbh->prepare("SELECT * FROM memberReaders WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // パスワードの検証とセッションの設定
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = false;
            header("Location: welcome.php");
            exit;
        } else {
            $error_message = "メールアドレスまたはパスワードが間違っています。";
        }
    } catch (PDOException $e) {
        $error_message = "エラー: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <div style="height: 225px;"></div>
        <div class="container">
            <h2>ログイン</h2>
            <p class="error-message"><?php echo $error_message; ?></p>
            <button onclick="history.back()" class="guest-button">戻る</button>
        </div>
    <?php else: ?>
        <div style="height: 100px;"></div>
        <div class="container">
            <h2>ログイン</h2>
            <form action="login.php" method="post">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" placeholder="sample@email.com" required>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" class="login-button">ログイン</button>
            </form>
            <button onclick="location.href='new.php'" class="register-button">新規登録</button>
            <button onclick="location.href='listbooks.php'" class="guest-button">戻る</button>
        </div>
    <?php endif; ?>
</body>
</html>
