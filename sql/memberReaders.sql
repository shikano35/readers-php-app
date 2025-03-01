DROP TABLE IF EXISTS memberReaders;
CREATE TABLE memberReaders (
    id          MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
    username    VARCHAR(50),
    email       VARCHAR(100),
    password    VARCHAR(128),
    reg_date    DATETIME,
    PRIMARY KEY (id)
);

INSERT INTO memberReaders VALUES (NULL, 'sample', 'sample@email','sample', NULL);