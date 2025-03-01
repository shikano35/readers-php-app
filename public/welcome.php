<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['username'];

$loggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$userId = $loggedIn ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ようこそ</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/detail.css">
</head>
<body>
    <?php
    define('ACCESS_ALLOWED', true);
    include('header.php');
    ?>

    <div style="height: 225px;"></div>
        <div class="container">
            <h2>ようこそ、 <?php echo htmlspecialchars($username); ?> さん！</h2>
            <button onclick="location.href='listbooks.php'" class="login-button">戻る</button>
        </div>
    </body>
    <script src="assets/js/detail.js"></script>
</html>
