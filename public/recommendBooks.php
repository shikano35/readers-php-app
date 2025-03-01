<?php
$loggedIn = isset($_SESSION['user_id']);
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

    // ユーザーのお気に入り書籍IDを取得
    $favoriteBooks = [];
    if ($loggedIn) {
        $sql = "SELECT book_id FROM favorites WHERE user_id = :user_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favoriteBooks[] = $row['book_id'];
        }
    }

    // 書籍データをランダムに取得
    $sql = "SELECT * FROM books ORDER BY RAND() LIMIT 9"; // おすすめ書籍としてランダムに9件取得
    $stmt = $dbh->query($sql);

    // 結果が1件以上ある場合は書籍情報を表示
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $isFavorite = in_array($row['id'], $favoriteBooks);
            
            echo '<div class="book" data-id="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" data-genre="' . htmlspecialchars($row['genre'], ENT_QUOTES, 'UTF-8') . '" data-author="' . htmlspecialchars($row['writer'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<img src="' . htmlspecialchars($row['book_image'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($row['book_name'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<h2>' . htmlspecialchars($row['book_name'], ENT_QUOTES, 'UTF-8') . '</h2>';
            echo '<p><strong>著者:</strong> ' . htmlspecialchars($row['writer'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p><strong>ジャンル:</strong> ' . htmlspecialchars($row['genre'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p><strong>発行年:</strong> ' . htmlspecialchars($row['years'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<button class="favorite-button" data-id="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">' . ($isFavorite ? '♥' : '♡') . '</button>';
            echo '</div>';
        }
    } else {
        echo "おすすめ書籍が見つかりませんでした";
    }

    // データベース接続をクローズ
    $dbh = null;
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
}
?>
