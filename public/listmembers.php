<?php
session_start();
$pageTitle = "会員一覧";
$add = "addmember.php";
include 'headerList.php';
?>
<main>
    <section>
        <h2 class="section-title">会員一覧</h2>
        <div id="book-container" class="book-container">
            <?php include 'members.php'; ?>
        </div>
    </section>
</main>
<script src="assets/js/listmembers.js"></script>
</body>
</html>
