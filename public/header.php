<?php
if (!defined('ACCESS_ALLOWED')) {
    die('直接のアクセスを許可していません。');
}
?>

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
                <li><a href="listrecommend.php" class="menu-item">おすすめ</a></li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                <li><a href="listmembers.php" class="menu-item">会員一覧</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php if ($loggedIn): ?>
        <a href="logout.php" class="login-btn">ログアウト</a>
    <?php else: ?>
        <a href="login.php" class="login-btn">ログイン</a>
    <?php endif; ?>
</header>
