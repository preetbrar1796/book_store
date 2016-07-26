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
    <title>Book Store</title>
</head>
<body>
<!--include the header.php to get header of the page-->
<?php include "header.php" ?>
<div class="container">
    <section>
        <center>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <!--heading of the page-->
            <div>
                <hr>
                <h1>WELCOME TO VIRTUAL BOOK STORE</h1>
                <hr>
            </div>
            <div id="desc">
                This book store gives you the ability to add authors and books by those authors. You can see the stored
                authors and books in the database.Using the ISBN of the book, the book store also gets information from
                <a href="https://www.goodreads.com">goodreads.com</a> using goodreads
                <a href="https://www.goodreads.com/api">API</a>.
            </div>
        </center>
    </section>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>