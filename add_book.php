<?php
//store the post array into variables
extract($_POST);

//start the session to store variables
session_start();

//set the validation to true
$validated = true;

//validate and sanitize the team id
if ($authorId == ""):
    $_SESSION["errAuthorId"] = "Please select the author's name";
    $validated = false;
else:
    $authorId = filter_var($authorId, FILTER_SANITIZE_NUMBER_INT);
endif;

//validate and sanitize the book's name
if (empty($bname)):
    $validated = false;
    $_SESSION["errBookName"] = "Please input the correct name";
else:
    $bname = filter_var($bname, FILTER_SANITIZE_STRING);
endif;

//validate and sanitize the book's isbn
if (empty($bisbn) || strlen($bisbn) != "10"):
    $validated = false;
    $_SESSION["errBookIsbn"] = "Please input the correct ISBN of the book";
else:
    $bisbn = filter_var($bisbn, FILTER_SANITIZE_NUMBER_INT);
endif;

//sanitize the release date
if (!empty($releaseDate)):
    $releaseDate = filter_var($releaseDate, FILTER_SANITIZE_STRING);
endif;

//sanitize the publisher
if (!empty($publisher)):
    $publisher = filter_var($publisher, FILTER_SANITIZE_STRING);
endif;

//sanitize the language
if (!empty($language)):
    $language = filter_var($language, FILTER_SANITIZE_STRING);
endif;

//if there is any error redirect to form page and show the errors and populate the user's data
if (!$validated):
    $_SESSION["errorBook"] = "The book could not be added due to following error(s)";
    $_SESSION = array_merge($_SESSION, $_POST);
    header("Location: new_book.php");
    exit;
else:
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "INSERT INTO tblbooks(book_name, book_ISBN, book_release_date, book_publisher, book_language, author_id)
    VALUES(:book_name, :book_ISBN, :book_release_date, :book_publisher, :book_language, :author_id)";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':book_name', $bname, PDO::PARAM_STR, 100);
    $sth->bindParam(':book_ISBN', $bisbn, PDO::PARAM_INT);
    $sth->bindParam(':book_release_date', $releaseDate, PDO::PARAM_STR);
    $sth->bindParam(':book_publisher', $publisher, PDO::PARAM_STR, 100);
    $sth->bindParam(':book_language', $language, PDO::PARAM_STR, 30);
    $sth->bindParam(':author_id', $authorId, PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //set the database connection to null, to end the connection
    $dbh = null;

    //success message to be shown
    $_SESSION['success'] = 'The book has been added successfully';

    //redirect to players page to show the added player
    header("Location: books.php?authorId=" . $authorId);
endif;
