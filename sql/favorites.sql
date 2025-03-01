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