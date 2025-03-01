<?php
session_start();

// 管理者以外は会員一覧にリダイレクト
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
$password = "password";
$dbname = "readers";

// 会員IDの取得
$memberId = $_GET['id'] ?? null;
$member = null;
$error = '';

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST['member_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $reg_date = $_POST['reg_date'];

    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username_db, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 会員データの更新
        $sql = "UPDATE memberReaders SET username = :username, email = :email, reg_date = :reg_date WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':reg_date', $reg_date);
        $stmt->bindParam(':id', $memberId);

        if ($stmt->execute()) {
            header("Location: listmembers.php");
            exit;
        } else {
            $error = "更新に失敗しました。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
} elseif ($memberId) {
    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username_db, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 会員データの取得
        $sql = "SELECT * FROM memberReaders WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $memberId);
        $stmt->execute();
        $member = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$member) {
            $error = "会員が見つかりません。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
} else {
    header("Location: listmembers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員編集</title>
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
            <h2 class="section-title">会員編集</h2>
            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
                <form action="editmember.php" method="post">
                    <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="username">ユーザー名</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($member['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="email">メール</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="reg_date">会員登録日</label>
                    <input type="datetime" id="reg_date" name="reg_date" value="<?php echo htmlspecialchars($member['reg_date'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <button type="submit" class="login-button">更新</button>
                </form>
            <?php endif; ?>
            <button onclick="location.href='listmembers.php'" class="guest-button">戻る</button>
        </div>
    </main>

    <script src="assets/js/listbooks.js"></script>
</body>
</html>
