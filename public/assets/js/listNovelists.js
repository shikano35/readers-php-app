document.addEventListener('DOMContentLoaded', function () {
    const refreshButton = document.getElementById('refresh-button');
    const bookContainer = document.getElementById('book-container');
    const books = document.querySelectorAll('.book');
    const searchButton = document.getElementById('search-button');
    const searchBox = document.getElementById('search-box');
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');
    const menuItems = document.querySelectorAll('.menu-item');

    // 書籍クリック時の動作
    books.forEach(function (book) {
        book.addEventListener('click', function () {
            const bookId = book.getAttribute('data-id');
            window.location.href = 'detailNovelist.php?id=' + bookId;
        });
    });

    // 検索ボタンクリック時の動作
    function performSearch() {
        const query = searchBox.value.toLowerCase();
        const results = [];

        books.forEach(function (book) {
            const title = book.querySelector('h2').textContent.toLowerCase();
            const author = book.querySelector('p:nth-child(3)').textContent.toLowerCase();
            const genre = book.querySelector('p:nth-child(4)').textContent.toLowerCase();

            if (title.includes(query) || author.includes(query) || genre.includes(query)) {
                results.push(book.outerHTML);
            }
        });

        if (results.length > 0) {
            bookContainer.innerHTML = results.join('');
        } else {
            bookContainer.innerHTML = '<p class="no-results">\'' + searchBox.value + '\' に一致した作品はありませんでした。</p>';
        }

        const newBooks = document.querySelectorAll('.book');
        newBooks.forEach(function (book) {
            book.addEventListener('click', function () {
                const bookId = book.getAttribute('data-id');
                window.location.href = 'detailNovelist.php?id=' + bookId;
            });
        });

        addFavoriteButtonListeners(); // お気に入りボタンのイベントリスナーを追加
    }

    // 検索ボタンのクリックイベント
    searchButton.addEventListener('click', performSearch);

    // Enterキーが押されたときの処理
    searchBox.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            performSearch();
        }
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

    // ページ読み込み時に初期設定を実行
    handleResize();

    // ウィンドウサイズが変更されたときに実行
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

    // メニューのリンクをクリックしたときにページ遷移する
    menuItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault(); // リンクのデフォルト動作をキャンセル
            const href = this.getAttribute('href');
            window.location.href = href; // リンク先に遷移
        });
    });

    // お気に入りボタンのイベントリスナーを追加する関数
    function addFavoriteButtonListeners() {
        const favoriteButtons = document.querySelectorAll('.favorite-button');
        favoriteButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.stopPropagation();

                const novelistId = this.getAttribute('data-id');
                const self = this;

                if (loggedIn) {
                    fetch('toggle_favorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ novelist_id: novelistId, user_id: userId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.favorited) {
                                    self.textContent = '♥'; // お気に入りに追加された場合の処理
                                } else {
                                    self.textContent = '♡'; // お気に入りが解除された場合の処理
                                }
                            } else {
                                console.error(data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    alert('ログインしてください。');
                }
            });
        });
    }

    addFavoriteButtonListeners(); // 初期化時にイベントリスナーを追加
});
