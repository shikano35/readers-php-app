<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo json_encode(['success' => false, 'message' => '権限がありません']);
    exit;
}

// リクエストデータを取得
$data = json_decode(file_get_contents('php://input'), true);
$memberId = $data['id'] ?? null;

// IDが指定されていない場合はエラーメッセージを返す
if (!$memberId) {
    echo json_encode(['success' => false, 'message' => '無効なリクエスト']);
    exit;
}

// データベースへの接続情報
$servername = "localhost";
$username = "readers";
$password_db = "password";
$dbname = "readers";

try {
    // データベースに接続
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
    $dbh = new PDO($dsn, $username, $password_db);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 会員を削除
    $stmt = $dbh->prepare("DELETE FROM memberReaders WHERE id = :id");
    $stmt->bindParam(':id', $memberId, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "データベースエラー: " . $e->getMessage()]);
}
?>
