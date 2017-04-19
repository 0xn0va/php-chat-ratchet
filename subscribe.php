<?php


session_start();

require_once 'main.php';

$new_msg = new main();

if ($new_msg->is_logged_in() != "") {
    $new_msg->redirect('dashboard.php');
}
if (isset($_POST['btn-signup'])) {
    $username = trim($_POST['input_name']);
    $email = trim($_POST['input_email']);
    $password = trim($_POST['input_password']);
    $salt = $new_msg->hashsalt();
    $verification = md5(uniqid(rand()));

    $result = $new_msg->runQuery("SELECT * FROM users WHERE u_Email=:email_id");
    $result->execute(array(":email_id" => $email));
    $row = $result->fetch(PDO::FETCH_ASSOC);


    if ($email && $email != '') {
        $inputdomain = end(explode('@', $email));
        $domains = array("hotmail.com", "yahoo.com");
        if (in_array($inputdomain, $domains)) {
            $msg = "
            <div class='alert alert-error'>
                <button class='close' data-dismiss='alert'>&times;</button>
                Ouch, sorry for this but you can only login with corporate email address
            </div>
            ";
        } else {
            if ($result->rowCount() > 0) {
                $msg = "
                <div class='alert alert-error'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    Your data is with us, don't register again, please login instead!
                </div>
                ";
            } else {
                if ($new_msg->form($username, $email, $password, $salt, $verification)) {
                    $id = $new_msg->lastID();
                    $key = base64_encode($id);
                    $id = $key;

                    $message = "
                    Hey $username,
                    <br />
                    You subscribed!<br/>
                    You just need to click on the following link to verify your email<br/>
                    <a href='http://localhost/liana/abdo/verification.php?id=$id&code=$verification'>CLICK ON ME!</a><br />
                    Best Regards,";

                    $subject = "Verify Subscription";

                    $new_msg->send_mail($email, $message, $subject);
                    $msg = "
                    <div class='alert alert-success'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Thats it!, we just sent an email to the address you just entered, please verify your email</strong>
                    </div>
                    ";
                } else {
                    echo "Ouch, something is wrong! :(";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscribe</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="resources/css/style.css" rel="stylesheet" media="screen">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

      <style type="text/css">

       body {
            background-image: url("resources/1.png");
            background-size: cover;
            font-family: "Calibri", "Roboto", sans-serif;
        }

        .form-signin-heading {
            font-style: bold;
            font-weight: 500;
            color: #edeff2;
        }

        a {
            color: #edeff2;
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
            font-size: 18px;
        }

    </style>
</head>
<body id="login">
    <div class="container">
        <?php if (isset($msg)) echo $msg; ?>
        <form class="form-signin" method="post">

            <h2 class="form-signin-heading">Subscribe</h2>
            <label for="inputName" class="sr-only">Name</label>
            <input type="text" class="form-control" placeholder="Name" name="input_name" required autofocus>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" class="form-control" placeholder="Email address" name="input_email" required>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" class="form-control" placeholder="Password" name="input_password" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-signup">Subscribe</button>
            <a href="index.php" style="float:right;" class="btn btn-large">Login</a>

        </form>
    </div>
    <script src="resources/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
