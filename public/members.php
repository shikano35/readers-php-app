<?php
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$userId = $loggedIn ? $_SESSION['user_id'] : null;

// データベースへの接続情報
$servername = "localhost";
$username = "readers";
$password = "password";
$dbname = "readers";

try {
    // データベースに接続
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 会員データを取得
    $sql = "SELECT * FROM memberReaders";
    $stmt = $dbh->query($sql);

    // 結果が1件以上ある場合は会員情報を表示
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="book member" data-id="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<h2>' . htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '<p><strong>メール:</strong> ' . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p><strong>会員登録日:</strong> ' . htmlspecialchars($row['reg_date'], ENT_QUOTES, 'UTF-8') . '</p>';
            if ($isAdmin) {
                echo '<button class="delete-button">×</button>';
            }
            echo '</div>';
        }
    } else {
        echo "0件の結果";
    }

    // データベース接続をクローズ
    $dbh = null;
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
}
?>
