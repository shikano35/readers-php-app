DROP TABLE IF EXISTS books;
CREATE TABLE books (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    comment     TEXT,
    book_name   VARCHAR(255) NOT NULL,
    writer   	VARCHAR(255) NOT NULL,
    genre  	    VARCHAR(255) NOT NULL,
    book_image 	VARCHAR(255) NOT NULL,
    book_url    VARCHAR(1000) NOT NULL,
    years       VARCHAR(255)
);

INSERT INTO books VALUES (NULL, '平生はみんな善人なんです。少なくともみんな普通の人間なんです。それが、いざという間際に、急に悪人に変るんだから恐ろしいのです。', 'こころ', '夏目漱石', 'フィクション', 'https://m.media-amazon.com/images/I/91Bu5PuDz5L._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000148/files/773_14560.html', '1914年');