<?php
$loggedIn = isset($userId);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

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

    // ユーザーのお気に入り小説家IDを取得
    $favoriteNovelists = [];
    if ($loggedIn) {
        $sql = "SELECT novelist_id FROM favorites WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favoriteNovelists[] = $row['novelist_id'];
        }
    }

    // 小説家データを取得
    $sql = "SELECT * FROM novelist";
    $stmt = $dbh->query($sql);

    // 結果が1件以上ある場合は小説家情報を表示
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $isFavorite = in_array($row['id'], $favoriteNovelists);
            
            echo '<div class="book" data-id="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<img src="' . htmlspecialchars($row['novelist_image'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['novelist_name'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<h2>' . htmlspecialchars($row['novelist_name'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '<p>' . htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p>' . htmlspecialchars($row['books'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p>' . htmlspecialchars($row['years'], ENT_QUOTES, 'UTF-8') . '</p>';
            if (!$isAdmin) {
                echo '<button class="favorite-button" data-id="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">' . ($isFavorite ? '♥' : '♡') . '</button>';
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
