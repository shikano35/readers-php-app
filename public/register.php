<?php
// データベースへの接続情報
$servername = "localhost";
$username = "readers";
$password_db = "password";
$dbname = "readers";

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_input = $_POST['username'];
    $email = $_POST['email'];
    $password_input = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $reg_date = date("Y-m-d H:i:s");

    try {
        // データベースに接続
        $dsn = "mysql:dbname=$dbname;host=$servername;charset=utf8";
        $dbh = new PDO($dsn, $username, $password_db);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // メールアドレスの重複を確認
        $stmt = $dbh->prepare("SELECT COUNT(*) FROM memberReaders WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            $error_message = "すでに登録されています";
        } else {
            // ユーザー情報を挿入
            $stmt = $dbh->prepare("INSERT INTO memberReaders (username, email, password, reg_date) VALUES (:username, :email, :password, :reg_date)");
            $stmt->bindParam(':username', $username_input);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_input);
            $stmt->bindParam(':reg_date', $reg_date);

            $stmt->execute();
            $success_message = "登録が完了しました";
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
    <title>新規登録</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <?php if (!empty($error_message)) : ?>
        <div style="height: 200px;"></div>
        <div class="container">
        <h2>新規登録</h2>
        <p class="error-message"><?php echo $error_message; ?></p>
        <button onclick="history.back()" class="login-button">戻る</button>
    <?php elseif (!empty($success_message)) : ?>
        <div style="height: 200px;"></div>
        <div class="container">
        <h2>新規登録</h2>
        <p><?php echo $success_message;?></p>
        <button onclick="location.href='listbooks.php'" class="login-button">書籍一覧へ</button>
    <?php else : ?>
        <div style="height: 100px;"></div>
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
            <button onclick="location.href='listbooks.php'" class="guest-button">書籍一覧へ</button>
        </form>
    <?php endif; ?>
</body>
</html>
