<!-- <?php


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
?>  -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <link href="resources/css/style.css" rel="stylesheet" media="screen">
  <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

  <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto+Slab'>


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <style type="text/css">

          body {
            background-image: url("resources/1.png");
            background-size: cover;
            font-family: "Roboto Slab", "Calibri", sans-serif;
        }

        .form-signin-heading {
            font-style: bold;
            font-weight: 500;
            color: #edeff2;
        }

        .form-signin-heading, .btn {
        text-shadow: 0 1px 3px rgba(0,0,0,.5);
        }

        a {
            color: #edeff2;
        }

        .btn {
            font-size: 18px;
        }
        
         .btn:hover {
            color: #de2a3d;
        }

        .btn-primary {
            background-color: #edeff2;
            color: #de2a3d;
        }

        .btn-primary:hover {
            color: #edeff2;
             background-color: #de2a3d;
            border-color: #edeff2;
        }

      .form-signin .form-control {
            color: #de2a3d;
            font-size: 16px;
        }

        .form-group {
             position: relative;
            margin-bottom: 10px;
         }

        .form-group .fa {
              position: absolute;
              right: 15px;
              top: 17px;
              color: #999;
        }

        .log-status.wrong-entry {
          -moz-animation: wrong-log 0.3s;
          -webkit-animation: wrong-log 0.3s;
          animation: wrong-log 0.3s;
        }

        /*.log-status.wrong-entry .form-control, .wrong-entry .form-control + .fa {*/
        .log-status:focus {
          border-color: #ed1c24;
          color: #ed1c24;
        }

        .alert {
          display: none;
          font-size: 14px;
          float: left;
        }

    </style>
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

            <div class="form-group">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" class="form-control" placeholder="Email address" name="input_email" required>
                <i class="fa fa-user"></i>

           </div>

            <div class="form-group log-status">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" placeholder="Password" name="input_password" required>
            <i class="fa fa-lock"></i>
           </div>

            <span class="alert">Invalid Credentials</span>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-login">Login</button>
            <a href="subscribe.php" style="float:right;" class="btn btn-large">Subscribe</a>
        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
       <script src="resources/index.js"></script>
    
</body>
</html>
