<?php

// セッションを開始
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
$userId = $loggedIn ? $_SESSION['user_id'] : null;

// 現在のスクリプト名を取得
$currentScript = basename($_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="assets/css/listbooks.css">
</head>
<body>
    <header>
        <div class="menu-container">
            <div class="menu-toggle" id="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <a href="index.php" class="site-title">Readers</a>
            <nav class="menu">
                <ul>
                    <li><a href="index.php" class="menu-item">トップページ</a></li>
                    <li><a href="listbooks.php" class="menu-item">書籍一覧</a></li>
                    <li><a href="listNovelists.php" class="menu-item">小説家一覧</a></li>
                    <?php if (!$isAdmin): ?>
                    <li><a href="listfavorites.php" class="menu-item">お気に入り書籍一覧</a></li>
                    <li><a href="listfavoritesNovelists.php" class="menu-item">お気に入り小説家一覧</a></li>
                    <li><a href="listrecommend.php" class="menu-item">おすすめ書籍一覧</a></li>
                    <?php endif; ?>
                    <?php if ($isAdmin): ?>
                    <li><a href="listmembers.php" class="menu-item">会員一覧</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php if ($currentScript !== 'listmembers.php'): ?>
        <div class="search-container">
            <input type="text" id="search-box" class="search-box" 
                   placeholder="<?php echo $currentScript === 'listNovelists.php' ? '著者、職業、代表作で検索...' : 'タイトル、著者、ジャンルで検索...'; ?>">
            <button id="search-button" class="search-button">
                <img src="assets/images/magnifyingGlass.png" alt="検索">
            </button>
        </div>
        <?php endif; ?>
        <div class="auth-buttons">
            <?php if ($loggedIn): ?>
                <?php if ($isAdmin): ?>
                    <a href=<?php echo htmlspecialchars($add, ENT_QUOTES, 'UTF-8'); ?> class="login-btn">追加</a>
                <?php endif; ?>
                <a href="logout.php" class="login-btn">ログアウト</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">ログイン</a>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>
