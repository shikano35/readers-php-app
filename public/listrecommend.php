<?php
session_start();
$pageTitle = "おすすめ書籍一覧";
include 'headerList.php';
?>

<main>
    <section>
        <button id="refresh-button" class="refresh-button">
            <img src="assets/images/update.png" alt="更新">
        </button>
        <h2 class="section-title">　　おすすめ書籍一覧</h2>
        <div id="book-container" class="book-container">
            <?php include 'recommendBooks.php';?>
        </div>
    </section>
</main>

<script>
    const loggedIn = <?php echo json_encode($loggedIn); ?>;
    const userId = <?php echo json_encode($userId); ?>;
</script>
<script src="assets/js/listrecommend.js"></script>
</body>
</html>
