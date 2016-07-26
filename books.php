<?php
//start the session to get session variables
session_start();

//store the session array into variables
extract($_SESSION);

//unset the session variables
session_unset();

//check if we can get authorId
if (isset($_GET["authorId"])):

    //get connect.php to connect to database
    require "connect.php";

    //build the sql
    $sql = "SELECT * FROM tblbooks WHERE author_id =:id";

    //prepare the sql statement
    $sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':id', $_GET["authorId"], PDO::PARAM_INT);

    //execute the sql statement
    $sth->execute();

    //store all the rows from database into books
    $books = $sth->fetchAll();

    //store all the row count from database into row_count
    $row_count = $sth->rowCount();

    //set the database connection to null, to end the connection
    $dbh = null;

else:
    header("Location: authors.php");
endif;
?>

<!DOCTYPE HTML>
<html lang="en">
<!--head region of the page-->
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>Books</title>
</head>
<body>
<!--include the header.php to get header of the page-->
<?php include "header.php" ?>
<div class="container">
    <!--if there is any success message after the new addition of book it goes here-->
    <?php if (isset($success)): ?>
        <div class="alert alert-success">
            <?= $success; ?>
        </div>
    <?php endif; ?>
    <section>
        <!--build the table only if there is any book stored-->
        <?php if ($row_count > 0): ?>
            <div>
                <!--heading of the page-->
                <h1>Books</h1>
            </div>
            <div id="books">
                <?php $index = 1 ?>
                <?php foreach ($books as $book): ?>
                    <?php
                    //get the image and description of the book from goodread api if we have correct ISBN
                    $request = get_headers("https://www.goodreads.com/book/isbn/" . $book['book_ISBN'] .
                        "?key=IKmEzVpI6eyFqHiXXvVwQ");
                    if (strpos($request[0], "200 OK")) {
                        $xmlDoc = file_get_contents("https://www.goodreads.com/book/isbn/" . $book['book_ISBN'] .
                            "?key=IKmEzVpI6eyFqHiXXvVwQ");
                        $xml = simplexml_load_string($xmlDoc);
                        $imagesrc = $xml->xpath('/GoodreadsResponse/book/image_url');
                        $image = implode(",", $imagesrc);
                        $descriptionsrc = $xml->xpath('/GoodreadsResponse/book/description');
                        $description = implode(",", $descriptionsrc);
                    } else {
                        $image =
                            "https://s.gr-assets.com/assets/nophoto/book/111x148-bcc042a9c91a29c1d680899eff700a03.png";
                        $description = "Sorry no description found!!";
                    }
                    ?>
                    <div class="hidden-xs hidden-sm col-md-2 col-lg-2">
                        <img src="<?= $image ?>">
                    </div>
                    <dl class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <dt><?= $index . ". " ?>Book name: <?= $book['book_name'] ?></dt>
                        <?php if ($book['book_release_date'] != '0000-00-00'): ?>
                            <dd>Release Date: <?= $book['book_release_date'] ?></dd>
                        <?php endif; ?>
                        <?php if (!empty($book['book_publisher'])): ?>
                            <dd>Publisher: <?= $book['book_publisher'] ?></dd>
                        <?php else: ?>
                            <dd>No info found</dd>
                        <?php endif; ?>
                        <?php if (!empty($book['book_language'])): ?>
                            <dd>Language: <?= $book['book_language'] ?></dd>
                        <?php else: ?>
                            <dd>No info found</dd>
                        <?php endif; ?>
                        <dd class="hidden-xs hidden-sm">Description: <?= $description ?></dd>
                    </dl>
                    <?php if ($index < $row_count): ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <hr>
                        </div>
                    <?php endif; ?>
                    <?php $index++ ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!--if there was no book then give the warning to the user-->
            <div class="alert alert-warning">
                <p>No book found.<a href="new_book.php">&nbsp;&nbsp;Add Book</a></p>
            </div>
        <?php endif ?>
    </section>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>
