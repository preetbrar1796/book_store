CREATE TABLE tblauthors (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  author_fname VARCHAR(20) NOT NULL,
  author_lname VARCHAR(20) NOT NULL,
  author_birthday DATE DEFAULT NULL,
  author_gender ENUM('Male','Female') DEFAULT NULL,
  author_nationality VARCHAR(50) DEFAULT NULL,
  author_bio_link VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE tblbooks(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  book_name VARCHAR(200) NOT NULL,
  book_ISBN CHAR(10) NOT NULL,
  book_release_date DATE DEFAULT NULL,
  book_publisher VARCHAR(100) DEFAULT NULL,
  book_language VARCHAR(30) DEFAULT NULL,
  author_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (author_id) REFERENCES tblauthors (id) ON DELETE CASCADE ON UPDATE CASCADE
);