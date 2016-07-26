<?php
//start the session to get session variables
session_start();

//store the session array into variables
extract($_SESSION);

//unset the session variables
session_unset();
?>
<!DOCTYPE HTML>
<html lang="en">
<!--head region of the page-->
<head>
    <!--link to stylesheets-->
    <meta name="viewport" content="width=device-width initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O"
          crossorigin="anonymous">
    <link href="stylesheets/common.css" rel="stylesheet">
    <!--title of the page-->
    <title>New Author</title>
</head>
<body>
<!--include the header.php to get header of the page-->
<?php include "header.php" ?>
<div class="container">
    <!--if there is any error after the validation of the form it goes here-->
    <?php if (isset($errorAuthor)): ?>
        <div class="alert alert-danger">
            <?= $errorAuthor; ?>
        </div>
    <?php endif; ?>
    <div>
        <!--heading of the page-->
        <h1>Please provide the information below to add a new author to the list</h1>
    </div>
    <!--input form for the page-->
    <form class="form-horizontal" method="post" action="add_author.php">
        <fieldset>
            <legend>Author Information</legend>
            <div
                class="form-group <?php if (isset($errAuthorName)): echo " has-error has-feedback"; endif; ?>">
                <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="fname">First Name</label>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <input class="form-control input-sm" type="text" name="fname" placeholder="Author's first name"
                        <?php if (isset($fname)): echo "value=" . $fname; endif; ?>>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <input class="form-control input-sm" type="text" name="lname" placeholder="Author's last name"
                           max="20" required pattern="[A-Za-z]{3,}" title="Please provide correct last name"
                        <?php if (isset($lname)): echo "value=" . $lname; endif; ?>>
                </div>
                <!--if the error is in the name then it goes here-->
                <?php if (isset($errAuthorName)): ?>
                    <div class="text-danger"><?= $errAuthorName ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="birthday">Birthday</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <input class="form-control input-sm" type="date" name="birthday"
                        <?php if (isset($birthday)): echo "value=" . $birthday; endif; ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="gender">Gender</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label class="radio-inline"><input type="radio" name="gender" value="Male" checked>Male</label>
                    <label class="radio-inline"><input type="radio" name="gender" value="Female"
                            <?php if (isset($gender) && $gender == "Female"): echo "checked";endif; ?>>Female</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="nationality">Nationality</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <input class="form-control input-sm" type="text" name="nationality"
                           placeholder="Author's Nationality" max="50" pattern="[A-Za-z]{3,}"
                           title="Please provide correct country name"
                        <?php if (isset($nationality)): echo "value=" . $nationality; endif; ?>>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2 control-label" for="biolink">Bio Link</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <input class="form-control input-sm" type="url" name="biolink" placeholder="Author's bio link"
                           max="100" pattern="https?://.+" title="Please include http://"
                        <?php if (isset($biolink)): echo "value=" . $biolink; endif; ?>>
                </div>
            </div>
            <div class="input-group col-sm-offset-4 col-md-offset-3 col-lg-offset-2">
                <button class="btn btn-add"><i class="fa fa-plus"></i>&nbsp; &nbsp;Add Author</button>
            </div>
        </fieldset>
    </form>
</div>
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>
