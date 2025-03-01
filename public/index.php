<?php

session_start();

$isAdmin  = $_SESSION['is_admin'] ?? false;
$loggedIn = isset($_SESSION['user_id']);

define('ACCESS_ALLOWED', true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ホーム</title>
  <link rel="stylesheet" href="assets/css/listbooks.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <script src="assets/js/detail.js"></script>
</head>
<body>
  <?php
  require_once 'header.php';
  ?>

  <div class="container">
    <?php if (!$loggedIn): ?>
      <div class="spacer" style="height: 50px;"></div>
      <h2>ようこそ！</h2>
      <form action="login.php" method="post">
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" placeholder="sample@email.com" required>
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" class="login-button">ログイン</button>
      </form>
      <button onclick="location.href='new.php'" class="register-button">新規登録</button>
      <button onclick="location.href='listbooks.php'" class="guest-button">登録せずに始める</button>
    <?php else: ?>
      <div class="spacer" style="height: 150px;"></div>
      <h2>ようこそ！</h2>
      <p>こんにちは、<?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>さん！</p>
      <button onclick="location.href='listbooks.php'" class="login-button">戻る</button>
    <?php endif; ?>
  </div>
</body>
</html>
