create database readers character set utf8 collate utf8_general_ci;

create user 'readers'@'localhost' identified by 'password';
grant all privileges ON readers. * TO 'readers'@'localhost';
flush privileges;

use readers;

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

DROP TABLE IF EXISTS memberReaders;
CREATE TABLE memberReaders (
    id          MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
    username    VARCHAR(50),
    email       VARCHAR(100),
    password    VARCHAR(128),
    reg_date    DATETIME,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS favorites;
CREATE TABLE favorites (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id     MEDIUMINT UNSIGNED NOT NULL,
    book_id     INT UNSIGNED,
    novelist_id INT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES memberReaders(id),
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (novelist_id) REFERENCES novelist(id)
);

INSERT INTO books VALUES (NULL, '平生はみんな善人なんです。少なくともみんな普通の人間なんです。それが、いざという間際に、急に悪人に変るんだから恐ろしいのです。', 'こころ', '夏目漱石', 'フィクション', 'https://m.media-amazon.com/images/I/91Bu5PuDz5L._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000148/files/773_14560.html', '1914年');
INSERT INTO books VALUES (NULL, '弱虫は、幸福をさえおそれるものです。綿で怪我をするんです。幸福に傷つけられる事もあるんです。', '人間失格', '太宰治', 'フィクション', 'https://m.media-amazon.com/images/I/91nWeO7SbVL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000035/files/301_14912.html', '1948年');
INSERT INTO books VALUES (NULL, '吾輩は猫である。名前はまだ無い。', '吾輩は猫である', '夏目漱石', 'フィクション', 'https://m.media-amazon.com/images/I/91HbsSxUrTL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000148/files/789_14547.html', '1906年');
INSERT INTO books VALUES (NULL, '…………ブウウ――――――ンンン――――――ンンンン………………。', 'ドグラ・マグラ', '夢野久作', 'ミステリー', 'https://m.media-amazon.com/images/I/91XumC9p6bL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000096/files/2093_28841.html', '1935年');
INSERT INTO books VALUES (NULL, '下人の行方は、誰も知らない。', '羅生門', '芥川竜之介', 'フィクション', 'https://m.media-amazon.com/images/I/91u0SkeIxOL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000879/files/127_15260.html', '1915年');
INSERT INTO books VALUES (NULL, '誰だって、ほんとうにいいことをしたら、いちばん幸なんだねえ。', '銀河鉄道の夜', '宮沢賢治', '児童文学', 'https://m.media-amazon.com/images/I/91C3LC1T9+L._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000081/files/456_15050.html', '1934年');
INSERT INTO books VALUES (NULL, 'メロスは激怒した。', '走れメロス', '太宰治', 'フィクション', 'https://m.media-amazon.com/images/I/91TWhb608KL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000035/files/1567_14913.html', '1940年');
INSERT INTO books VALUES (NULL, '親譲りの無鉄砲で小供の時から損ばかりしている。', '坊っちゃん', '夏目漱石', 'フィクション', 'https://m.media-amazon.com/images/I/91NrBB3d-ZL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000148/files/752_14964.html', '1906年');
INSERT INTO books VALUES (NULL, '御釈迦様はその蜘蛛の糸をそっと御手に御取りになって、玉のような白蓮の間から、遥か下にある地獄の底へ、まっすぐにそれを御下しなさいました。', '蜘蛛の糸', '芥川竜之介', 'フィクション', 'https://m.media-amazon.com/images/I/516BWdYLvBL._SL500_.jpg', 'https://www.aozora.gr.jp/cards/000879/files/92_14545.html', '1918年');
INSERT INTO books VALUES (NULL, '人から尊敬されようと思わぬ人たちと遊びたい。けれども、そんないい人たちは、僕と遊んでくれやしない。', '斜陽', '太宰治', 'フィクション', 'https://m.media-amazon.com/images/I/91JAV3fmftL._SL1500_.jpg', 'https://www.aozora.gr.jp/cards/000035/files/1565_8559.html', '1947年');

INSERT INTO novelist VALUES (NULL, '小説家、英文学者','夏目漱石', '『吾輩は猫である』、『坊っちゃん』、『こゝろ』','1867年2月9日 - 1916年12月9日', 'https://upload.wikimedia.org/wikipedia/commons/1/17/Natsume_Soseki_photo.jpg', 'https://ja.wikipedia.org/wiki/夏目漱石');
INSERT INTO novelist VALUES (NULL, '小説家','太宰治', '『走れメロス』、『斜陽』、『人間失格』','1909年6月19日 - 1948年6月13日', 'https://upload.wikimedia.org/wikipedia/commons/7/77/Osamu_Dazai.jpg', 'https://ja.wikipedia.org/wiki/太宰治');
INSERT INTO novelist VALUES (NULL, '小説家','夢野久作', '『ドグラ・マグラ』、『氷の涯』、『少女地獄』','1889年1月4日 - 1936年3月11日', 'https://upload.wikimedia.org/wikipedia/commons/6/6d/Kyusaku_Yumeno.jpg', 'https://ja.wikipedia.org/wiki/夢野久作');
INSERT INTO novelist VALUES (NULL, '小説家','芥川龍之介', '『羅生門』、『藪の中』、『歯車』','1892年3月1日 - 1927年7月24日', 'https://upload.wikimedia.org/wikipedia/commons/1/10/Akutagawa_Ryunosuke_photo2.jpg', 'https://ja.wikipedia.org/wiki/芥川龍之介');
INSERT INTO novelist VALUES (NULL, '詩人、童話作家','宮沢賢治', '『銀河鉄道の夜』、『風の又三郎』、『セロ弾きのゴーシュ』','1896年8月27日 - 1933年9月21日', 'https://upload.wikimedia.org/wikipedia/commons/4/4d/Miyazawa_Kenji.jpg', 'https://ja.wikipedia.org/wiki/宮沢賢治');

INSERT INTO memberReaders VALUES (NULL, 'sample', 'sample@email','sample', NULL);