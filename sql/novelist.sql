DROP TABLE IF EXISTS novelist;
CREATE TABLE novelist (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    comment     TEXT,
    novelist_name   VARCHAR(255) NOT NULL,
    books   	VARCHAR(255) NOT NULL,
    years  	    VARCHAR(255) NOT NULL,
    novelist_image 	VARCHAR(1000) NOT NULL,
    novelist_url    VARCHAR(1000) NOT NULL
);

INSERT INTO novelist VALUES (NULL, '小説・俳句・漢詩・評論・随筆','夏目漱石', '『吾輩は猫である』、『坊っちゃん』、『こゝろ』','1867年2月9日-1916年12月9日', 'https://upload.wikimedia.org/wikipedia/commons/1/17/Natsume_Soseki_photo.jpg', 'https://ja.wikipedia.org/wiki/夏目漱石');