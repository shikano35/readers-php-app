<?php
session_start();
$pageTitle = "書籍一覧";
$add = "addbook.php";
include 'headerList.php';
?>

<main>
    <section>
        <h2 class="section-title">書籍一覧</h2>
        <div id="book-container" class="book-container">
            <?php include 'books.php'; ?>
        </div>
    </section>
</main>

<script>
const loggedIn = <?php echo json_encode($loggedIn); ?>;
const userId = <?php echo json_encode($userId); ?>;
const isAdmin = <?php echo json_encode($isAdmin); ?>;

if (isAdmin) {
    // 管理者の場合、編集ボタンと削除ボタンを表示
    document.querySelectorAll('.book').forEach(book => {
        // 編集ボタン
        const editButton = document.createElement('button');
        editButton.className = 'edit-button';
        const editIcon = document.createElement('img');
        editIcon.src = 'assets/images/edit.png';
        editButton.appendChild(editIcon);
        editButton.onclick = function(event) {
            event.stopPropagation();
            event.preventDefault();
            const bookId = book.getAttribute('data-id');
            window.location.href = 'editbook.php?id=' + bookId;
        };

        // 削除ボタン
        const deleteButton = document.createElement('button');
        deleteButton.innerHTML = '×';
        deleteButton.className = 'delete-button';
        deleteButton.onclick = function(event) {
            event.stopPropagation();
            event.preventDefault();
            const bookId = book.getAttribute('data-id');
            if (confirm('本当に削除しますか？')) {
                fetch('deletebook.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: bookId })
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          book.remove();
                      } else {
                          alert('削除に失敗しました。');
                      }
                  }).catch(error => {
                      console.error('エラー:', error);
                  });
            }
        };

        // 本の要素に編集ボタンと削除ボタンを追加
        book.appendChild(editButton);
        book.appendChild(deleteButton);
    });
}
</script>
<script src="assets/js/listrecommend.js"></script>
</body>
</html>
