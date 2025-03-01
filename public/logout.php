<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: listbooks.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト確認</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div style="height: 225px;"></div>
    <div class="container">
        <h2>本当にログアウトしますか？</h2>
        <form method="post" action="logout.php">
            <button type="submit" name="logout" class="login-button">ログアウトする</button>
        </form>
        <button onclick="history.back()" class="guest-button">戻る</button>
    </div>
</body>
</html>
