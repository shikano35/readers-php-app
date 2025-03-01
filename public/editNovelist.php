<?php
session_start();

// 管理者以外は小説家一覧にリダイレクト
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

// 小説家IDの取得
$novelistId = $_GET['id'] ?? null;
$novelist = null;
$error = '';

// POSTリクエストの場合
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novelistId = $_POST['novelist_id'];
    $novelistName = $_POST['novelist_name'];
    $novelistImage = $_POST['novelist_image'];
    $comment = $_POST['comment'];
    $books = $_POST['books'];
    $years = $_POST['years'];

    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 小説家データの更新
        $sql = "UPDATE novelist SET novelist_name = :novelist_name, novelist_image = :novelist_image, comment = :comment, books = :books, years = :years WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':novelist_name', $novelistName);
        $stmt->bindParam(':novelist_image', $novelistImage);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':books', $books);
        $stmt->bindParam(':years', $years);
        $stmt->bindParam(':id', $novelistId);

        if ($stmt->execute()) {
            header("Location: listNovelists.php");
            exit;
        } else {
            $error = "更新に失敗しました。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
} elseif ($novelistId) {
    try {
        // データベースに接続
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $dbh = new PDO($dsn, $username, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 小説家データの取得
        $sql = "SELECT * FROM novelist WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $novelistId);
        $stmt->execute();
        $novelist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$novelist) {
            $error = "小説家が見つかりません。";
        }
    } catch (PDOException $e) {
        $error = "エラー: " . $e->getMessage();
    }
} else {
    header("Location: listNovelists.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>小説家編集</title>
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
            <h2 class="section-title">小説家編集</h2>
            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
                <form action="editNovelist.php" method="post">
                    <input type="hidden" name="novelist_id" value="<?php echo htmlspecialchars($novelist['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="novelist_name">名前</label>
                    <input type="text" id="novelist_name" name="novelist_name" value="<?php echo htmlspecialchars($novelist['novelist_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="novelist_image">画像 URL</label>
                    <input type="text" id="novelist_image" name="novelist_image" value="<?php echo htmlspecialchars($novelist['novelist_image'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="comment">コメント</label>
                    <textarea id="comment" name="comment"  rows="4" cols="50" required><?php echo htmlspecialchars($novelist['comment'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    
                    <label for="books">著作</label>
                    <input type="text" id="books" name="books" value="<?php echo htmlspecialchars($novelist['books'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    
                    <label for="years">生涯</label>
                    <input type="text" id="years" name="years" value="<?php echo htmlspecialchars($novelist['years'], ENT_QUOTES, 'UTF-8'); ?>" required>

                    <button type="submit" class="login-button">更新</button>
                </form>
            <?php endif; ?>
            <button onclick="location.href='listNovelists.php'" class="guest-button">戻る</button>
        </div>
    </main>

    <script src="assets/js/listbooks.js"></script>
</body>
</html>
