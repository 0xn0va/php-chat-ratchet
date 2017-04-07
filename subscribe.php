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
        $domains = array("gmail.com", "hotmail.com", "yahoo.com");
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
    <title>Subscribe</title>
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="resources/css/style.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
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
