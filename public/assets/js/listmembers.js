document.addEventListener('DOMContentLoaded', function () {
    const bookContainer = document.getElementById('book-container');
    const books = document.querySelectorAll('.book');
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');
    const menuItems = document.querySelectorAll('.menu-item');

    // 書籍クリック時の動作
    books.forEach(function (book) {
        book.addEventListener('click', function () {
            const bookId = book.getAttribute('data-id');
            window.location.href = 'editmember.php?id=' + bookId;
        });
    });

    // ウィンドウサイズが変更されたときに実行する関数
    function handleResize() {
        const windowWidth = window.innerWidth;

        if (windowWidth >= 1200) {
            bookContainer.style.justifyContent = 'flex-start'; // 3つの枠を表示する場合は左詰め
        } else if (windowWidth >= 800) {
            bookContainer.style.justifyContent = 'flex-start'; // 2つの枠を表示する場合は左詰め
        } else {
            bookContainer.style.justifyContent = 'center'; // 1つの枠を表示する場合は中央配置
        }
    }

    // ページ読み込み時に初期設定を実行する
    handleResize();

    // ウィンドウサイズが変更されたときにも実行する
    window.addEventListener('resize', handleResize);

    // メニューの表示・非表示を切り替えるイベントリスナー
    menuToggle.addEventListener('click', function () {
        document.querySelector('.menu').classList.toggle('active');
    });

    // タブ以外の部分をクリックしたときにタブを閉じる
    document.addEventListener('click', function (event) {
        if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
            menu.classList.remove('active');
        }
    });

    menuItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault(); // リンクのデフォルト動作をキャンセル
            const href = this.getAttribute('href');
            window.location.href = href; // リンク先に遷移
        });
    });

    // 管理者ボタンのイベントリスナーを追加
    function addAdminButtonListeners() {
        const isAdmin = true; // 管理者フラグの設定

        if (isAdmin) {
            document.querySelectorAll('.member').forEach(member => {
                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '×';
                deleteButton.className = 'delete-button';
                deleteButton.onclick = function (event) {
                    event.stopPropagation();
                    event.preventDefault();
                    const memberId = member.getAttribute('data-id');
                    if (confirm('本当に削除しますか？')) {
                        fetch('deletemember.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: memberId })
                        }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    member.remove();
                                } else {
                                    alert('削除に失敗しました。');
                                }
                            }).catch(error => {
                                console.error('エラー:', error);
                            });
                    }
                };
                member.appendChild(deleteButton);
            });
        }
    }

    // ページ読み込み時に管理者ボタンのイベントリスナーを追加
    addAdminButtonListeners();
});
