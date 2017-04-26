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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cover</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto+Slab'>
    <style type="text/css">
    body {
        background-image: url("resources/2.jpg");
        background-size: cover;
        font-family: "Roboto Slab", "Calibri", sans-serif;
        color: #edeff2;
        box-shadow: inset 0 0 100px rgba(0, 0, 0, .5);
    }

    /*.cover-wrapper {
        display: table;
        width: 100%;
        height: 100%;
        min-height: 100%;
        -webkit-box-shadow: inset 0 0 100px rgba(0, 0, 0, .5);
    }

    .wrapper {
        display: table-cell;
        vertical-align: top;
    }
    */
    a {
        color: #edeff2;
        text-decoration: none;
    }

    a:hover {
        color: #de2a3d;
    }

    .login--toggle-container {
        position: absolute;
        top: 40%;
        left: 60%;
        margin: 0 auto;
        /*background-color: #F15A5C;*/
        /* right: 0;*/
        line-height: 2.5em;
        /*width: 50%;
        height: 120px;*/
        text-align: right;
        cursor: pointer;
        /*transform: perspective(1000px) translateZ(1px);
        transform-origin: 0% 0%;
        transition: all 1s cubic-bezier(0.06, 0.63, 0, 1);
        backface-visibility: hidden;*/
    }

    .login--toggle-container .js-toggle-login {
        font-size: 4em;
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="cover-wrapper">
        <div class="wrapper">
            <div class="container">
                <div class='login--toggle-container'>
                    <small>Hey you,</small>
                    <a href="login.php">
                        <div class='js-toggle-login'>Login</div>
                    </a>
                    <small>already</small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>


</html>
