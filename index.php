<?php


session_start();

require_once 'main.php';
$user_login = new main();

if ($user_login->is_logged_in() != "") {
    $user_login->redirect('dashboard.php');
}

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['input_email']);
    $password = trim($_POST['input_password']);

    if ($user_login->login($email, $password)) {
        $user_login->redirect('dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="resources/css/style.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body id="login">
<div class="container">
    <?php
    if (isset($_GET['inactive'])) {
        ?>
        <div class='alert alert-error'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong> Please activate your account, you can find activation email in your inbox.</strong>
        </div>
        <?php
    }
    ?>
    <form class="form-signin" method="post">
        <?php
        if (isset($_GET['error'])) {
            ?>
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong> Oops... Something is wrong here!</strong>
            </div>
            <?php
        }
        ?>

        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" class="form-control" placeholder="Email address" name="input_email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="input_password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-login">Login</button>
        <a href="subscribe.php" style="float:right;" class="btn btn-large">Subscribe</a>
    </form>

</div>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
