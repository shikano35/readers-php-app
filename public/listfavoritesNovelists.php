<?php
session_start();

// ログイン状態のチェック
$loggedIn = isset($_SESSION['user_id']);
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

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

    // お気に入り小説家の取得
    $sql = "SELECT novelist.* FROM novelist 
            JOIN favorites ON novelist.id = favorites.novelist_id 
            WHERE favorites.user_id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['user_id' => $userId]);

    $novelists = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dbh = null;
} catch (PDOException $e) {
    die("データベース接続エラー: " . $e->getMessage());
}
?>

<?php
$pageTitle = "お気に入り小説家一覧";
include 'headerList.php';
?>

    <main>
        <section>
            <h2 class="section-title">お気に入り小説家一覧</h2>
            <div id="book-container" class="book-container">
                <?php if (count($novelists) > 0): ?>
                    <?php foreach ($novelists as $novelist): ?>
                        <div class="book" data-id="<?php echo htmlspecialchars($novelist['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <img src="<?php echo htmlspecialchars($novelist['novelist_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($novelist['novelist_name'], ENT_QUOTES, 'UTF-8'); ?>">
                            <h2><?php echo htmlspecialchars($novelist['novelist_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                            <p><?php echo htmlspecialchars($novelist['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><?php echo htmlspecialchars($novelist['books'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><?php echo htmlspecialchars($novelist['years'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <button class="favorite-button novelist-favorite-button" data-id="<?php echo htmlspecialchars($novelist['id'], ENT_QUOTES, 'UTF-8'); ?>">♥</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-results">お気に入りに追加された小説家はいません。</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        const loggedIn = <?php echo json_encode(true); ?>;
        const userId = <?php echo json_encode($userId); ?>;
    </script>
    <script src="assets/js/listNovelists.js"></script>
</body>
</html>
