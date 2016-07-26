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
$sql = 'SELECT * FROM tblauthors';

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
    <!--link to stylesheets-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>Authors</title>
</head>
<body>
<!--include the header.php to get header of the page-->
<?php include "header.php" ?>
<div class="container">
    <!--if there is any success message after the new addition of author it goes here-->
    <?php if (isset($success)): ?>
        <div class="alert alert-success">
            <?= $success; ?>
        </div>
    <?php endif; ?>
    <section>
        <!--build the table only if there is any author info stored-->
        <?php if ($row_count > 0): ?>
            <div>
                <!--heading of the page-->
                <h1>Authors</h1>
            </div>
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Author name</th>
                    <th class="hidden-xs">Birthday</th>
                    <th class="hidden-xs">Gender</th>
                    <th class="hidden-xs">Nationality</th>
                    <th>Bio Link</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                <?php foreach ($authors as $author): ?>
                    <tr>
                        <td><?= $index ?></td>
                        <td>
                            <a href="books.php?authorId=<?= $author['id'] ?>"><?= $author['author_fname']
                                . " " . $author['author_lname'] ?></a>
                        </td>
                        <?php if ($author['author_birthday'] != 0000 - 00 - 00): ?>
                            <td class="hidden-xs"><?= $author['author_birthday'] ?> </td>
                        <?php else: ?>
                            <td class="hidden-xs">No info found</td>
                        <?php endif; ?>
                        <?php if (!empty($author['author_gender'])): ?>
                            <td class="hidden-xs"><?= $author['author_gender'] ?> </td>
                        <?php else: ?>
                            <td class="hidden-xs">No info found</td>
                        <?php endif; ?>
                        <?php if (!empty($author['author_nationality'])): ?>
                            <td class="hidden-xs"><?= $author['author_nationality'] ?> </td>
                        <?php else: ?>
                            <td class="hidden-xs">No info found</td>
                        <?php endif; ?>
                        <?php if (!empty($author['author_bio_link'])): ?>
                            <td><a href="<?= $author['author_bio_link'] ?>"><?= $author['author_bio_link'] ?></a></td>
                        <?php else: ?>
                            <td>No info found</td>
                        <?php endif; ?>
                    </tr>
                    <?php $index++ ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!--if there was no author then give the warning to the user-->
            <div class="alert alert-warning">
                <p>No author found.<a href="new_author.php">&nbsp;&nbsp;Add Author</a></p>
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
