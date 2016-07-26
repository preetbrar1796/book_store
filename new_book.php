<?php
//start the session to get session variables
session_start();

//store the session array into variables
extract($_SESSION);

//unset the session variables
session_unset();

//get connect.php to connect to database
require "connect.php";

//build the sql
$sql = 'SELECT id, author_fname, author_lname FROM tblauthors';

//prepare the sql statement
$sth = $dbh->prepare($sql);

//execute the sql statement
$sth->execute();

//store all the rows from database into authors
$authors = $sth->fetchAll();

//store all the row count from database into row_count
$row_count = $sth->rowCount();

//set the database connection to null, to end the connection
$dbh = null;

?>
<!DOCTYPE HTML>
<html lang="en">
<!--head region of the page-->
<head>
    <meta name="viewport" content="width=device-width initial-scale=1">
    <!--link to stylesheets-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O"
          crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>New Book</title>
</head>
<body>
<!--include the header.php to get header of the page-->
<?php include "header.php" ?>
<div class="container">
    <!--if there is any team stored then allow the user to add new player-->
    <?php if ($row_count > 0): ?>
        <!--if there is any error after the validation of the form it goes here-->
        <?php if (isset($errorBook)): ?>
            <div class="alert alert-danger">
                <?= $errorBook; ?>
            </div>
        <?php endif; ?>
        <div>
            <!--heading of the page-->
            <h1>Please provide the information below to add a new book to the list</h1>
        </div>
        <!--input form for the page-->
        <form class="form-horizontal" method="post" action="add_book.php">
            <fieldset>
                <legend>Book's Information</legend>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="authorId">Author</label>
                    <div class="input-group">
                        <select name="authorId" class="form-control col-xs-12 col-sm-12 col-md-3 col-lg-3" required>
                            <option value="">Author's</option>
                            <?php foreach ($authors as $author) : ?>
                                <option value="<?= $author['id'] ?>"
                                    <?php if (isset($authorId) && $author['id'] == $authorId): ?>
                                        <?= "selected"; ?>
                                    <?php endif; ?>>
                                    <?= $author['author_fname'] . ' ' . $author['author_lname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--if the error is in the selection of author then it goes here-->
                    <?php if (isset($errAuthorId)): ?>
                        <div class="text-danger"><?= $errAuthorId ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group<?php if (isset($errBookName)): echo " has-error has-feedback"; endif; ?>">
                    <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="bname">Book's Name</label>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <input class="form-control input-sm" type="text" name="bname" placeholder="Book's name"
                               max="100" required pattern="[A-Za-z\s]{3,}" title="Please provide correct book name"
                            <?php if (isset($bname)): echo "value=" . $bname; endif; ?>>
                    </div>
                    <!--if the error is in the input of book name then it goes here-->
                    <?php if (isset($errBookName)): ?>
                        <div class="text-danger col-xs-12 col-sm-4 col-md-4 col-lg-4"><?= $errBookName ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group<?php if (isset($errBookIsbn)): echo " has-error has-feedback"; endif; ?>">
                    <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="bisbn">Book's ISBN</label>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <input class="form-control input-sm" type="text" name="bisbn" placeholder="Book's ISBN"
                               title="Please enter correct 10 digit ISBN of a book"
                            <?php if (isset($bisbn)): echo "value=" . $bisbn; endif; ?>>
                    </div>
                    <!--if the error is in the input of book isbn then it goes here-->
                    <?php if (isset($errBookIsbn)): ?>
                        <div class="text-danger col-xs-12 col-sm-4 col-md-4 col-lg-4"><?= $errBookIsbn ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="releaseDate">Release
                        Date</label>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <input class="form-control input-sm" type="date" name="releaseDate"
                            <?php if (isset($releaseDate)): echo "value=" . $releaseDate; endif; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="publisher">Publisher</label>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <input class="form-control input-sm" type="text" name="publisher"
                               placeholder="Book's Publisher" max="100" pattern="[A-Za-z\s]{3,}"
                               title="Please provide correct publisher's name"
                            <?php if (isset($publisher)): echo "value=" . $publisher; endif; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="language">Language</label>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <input class="form-control input-sm" type="text" name="language" placeholder="Book's Language"
                               max="30" pattern="[A-Za-z\s]{3,}"
                            <?php if (isset($language)): echo "value=" . $language; endif; ?>>
                    </div>
                </div>
                <div class="input-group col-sm-offset-4 col-md-offset-3 col-lg-offset-2">
                    <button class="btn btn-add"><i class="fa fa-plus"></i>&nbsp; &nbsp;Add Book</button>
                </div>
            </fieldset>
        </form>
    <?php else: ?>
        <div class='alert alert-warning'>
            <p>No author found.<a href="new_author.php">&nbsp;&nbsp;Add Author</a></p>
        </div>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>