<?php
//store the post array into variables
extract($_POST);

//start the session to store variables
session_start();

//set the validation to true
$validated = true;

//validate and sanitize the author name
if (empty($fname) || empty($lname)):
    $validated = false;
    $_SESSION['errAuthorName'] = 'Please input the correct name';
else:
    $fname = filter_var($fname, FILTER_SANITIZE_STRING);
    $lname = filter_var($lname, FILTER_SANITIZE_STRING);
endif;

//sanitize the birthday
if (!empty($birthday)):
    $birthday = filter_var($birthday, FILTER_SANITIZE_STRING);
endif;

//sanitize the gender
if (!empty($gender)):
    $gender = filter_var($gender, FILTER_SANITIZE_STRING);
endif;

//sanitize the nationality
if (!empty($nationality)):
    $nationality = filter_var($nationality, FILTER_SANITIZE_STRING);
endif;

//sanitize the biolink
if (!empty($biolink)):
    $biolink = filter_var($biolink, FILTER_SANITIZE_URL);
endif;

//if there is any error redirect to the form page and show the errors and populate the user's data
if (!$validated):
    $_SESSION["errorAuthor"] = "The author could not be added due to following error(s)";
    $_SESSION = array_merge($_SESSION, $_POST);
    header("Location: new_author.php");
    exit;
else:
    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "INSERT INTO tblauthors(author_fname, author_lname, author_birthday, author_gender, author_nationality, author_bio_link)
    VALUES(:author_fname, :author_lname, :author_birthday, :author_gender, :author_nationality, :author_bio_link)";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':author_fname', $fname, PDO::PARAM_STR, 20);
    $sth->bindParam(':author_lname', $lname, PDO::PARAM_STR, 20);
    $sth->bindParam(':author_birthday', $birthday, PDO::PARAM_STR);
    $sth->bindParam(':author_gender', $gender, PDO::PARAM_STR);
    $sth->bindParam(':author_nationality', $nationality, PDO::PARAM_STR, 50);
    $sth->bindParam(':author_bio_link', $biolink, PDO::PARAM_STR, 100);

    //execute the sql statement
    $sth->execute();

    //set the database connection to null, to end the connection
    $dbh = null;

    //success message to be shown
    $_SESSION["success"] = "The author has been added successfully";

    //redirect to authors page to show the added team
    header("Location: authors.php");
    exit;
endif;
