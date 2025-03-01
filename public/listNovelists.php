<?php
session_start();
$pageTitle = "小説家一覧";
$add = "addNovelist.php";
include 'headerList.php';
?>
    <main>
        <section>
            <h2 class="section-title">小説家一覧</h2>
            <div id="book-container" class="book-container">
                <?php include 'novelist.php'; ?>
            </div>
        </section>
    </main>

    <script>
    const loggedIn = <?php echo json_encode($loggedIn); ?>;
    const userId = <?php echo json_encode($userId); ?>;
    const isAdmin = <?php echo json_encode($isAdmin); ?>;

        if (isAdmin) {
            // 管理者の場合、編集ボタンと削除ボタンを表示
            document.querySelectorAll('.book').forEach(novelist => {
                // 編集ボタン
                const editButton = document.createElement('button');
                editButton.className = 'edit-button';
                const editIcon = document.createElement('img');
                editIcon.src = 'assets/images/edit.png';
                editButton.appendChild(editIcon);
                editButton.onclick = function(event) {
                    event.stopPropagation();
                    event.preventDefault();
                    const novelistId = novelist.getAttribute('data-id');
                    window.location.href = 'editNovelist.php?id=' + novelistId;
                };

                // 削除ボタン
                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '×';
                deleteButton.className = 'delete-button';
                deleteButton.onclick = function(event) {
                    event.stopPropagation();
                    event.preventDefault();
                    const novelistId = novelist.getAttribute('data-id');
                    if (confirm('本当に削除しますか？')) {
                        fetch('deleteNovelist.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: novelistId })
                        }).then(response => response.json())
                          .then(data => {
                              if (data.success) {
                                  novelist.remove();
                              } else {
                                  alert('削除に失敗しました。');
                              }
                          }).catch(error => {
                              console.error('エラー:', error);
                          });
                    }
                };

                // 編集ボタンと削除ボタンを小説家の要素に追加
                novelist.appendChild(editButton);
                novelist.appendChild(deleteButton);
            });
        }
    </script>
    <script src="assets/js/listNovelists.js"></script>
</body>

</html>
