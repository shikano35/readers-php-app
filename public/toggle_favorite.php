<?php
session_start();

// ログインしていない場合はエラーメッセージを返す
if (!isset($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'ログインしてください。']);
    exit;
}

$userId = intval($_SESSION['user_id']);

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

    // お気に入りの書籍または小説家のIDを取得
    $data = json_decode(file_get_contents('php://input'), true);
    $bookId = isset($data['book_id']) && is_numeric($data['book_id']) ? intval($data['book_id']) : null;
    $novelistId = isset($data['novelist_id']) && is_numeric($data['novelist_id']) ? intval($data['novelist_id']) : null;

    // お気に入りの書籍または小説家のIDがある場合
    if ($bookId || $novelistId) {
        if ($bookId) {
            $sql = "SELECT * FROM favorites WHERE user_id = :user_id AND book_id = :book_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);

            if ($stmt->rowCount() > 0) {
                $sql = "DELETE FROM favorites WHERE user_id = :user_id AND book_id = :book_id";
                $stmt = $dbh->prepare($sql);
                $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);
                echo json_encode(['success' => true, 'favorited' => false]);
            } else {
                $sql = "INSERT INTO favorites (user_id, book_id) VALUES (:user_id, :book_id)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);
                echo json_encode(['success' => true, 'favorited' => true]);
            }
        } elseif ($novelistId) {
            $sql = "SELECT * FROM favorites WHERE user_id = :user_id AND novelist_id = :novelist_id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'novelist_id' => $novelistId]);

            if ($stmt->rowCount() > 0) {
                $sql = "DELETE FROM favorites WHERE user_id = :user_id AND novelist_id = :novelist_id";
                $stmt = $dbh->prepare($sql);
                $stmt->execute(['user_id' => $userId, 'novelist_id' => $novelistId]);
                echo json_encode(['success' => true, 'favorited' => false]);
            } else {
                $sql = "INSERT INTO favorites (user_id, novelist_id) VALUES (:user_id, :novelist_id)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute(['user_id' => $userId, 'novelist_id' => $novelistId]);
                echo json_encode(['success' => true, 'favorited' => true]);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => '無効なリクエストです。']);
    }

    $dbh = null;
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'データベース接続エラー: ' . $e->getMessage()]);
}
?>
