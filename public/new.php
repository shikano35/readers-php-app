<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div style="height: 80px;"></div>
    <div class="container">
        <h2>新規登録</h2>
        <form action="register.php" method="post">
            <label for="username">ユーザーネーム</label>
            <input type="text" id="username" name="username" required>
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="login-button">登録</button>
            <button onclick="history.back()" class="guest-button">戻る</button>
        </form>
    </div>
</body>
</html>
