<?php
session_start();
require_once 'main.php';
$new_msg = new main();
if (!$new_msg->is_logged_in()) {
	$new_msg->redirect('index.php');
}
$stmt = $new_msg->runQuery("SELECT * FROM users WHERE u_ID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userid = $row['u_ID'];

if (isset($_POST['btn-signup'])) {
	$username = trim($_POST['input_name']);
	$email = trim($_POST['input_email']);
	$password = trim($_POST['input_password']);
	$salt = $new_msg->hashsalt();
	$verification = md5(uniqid(rand()));

	$result = $new_msg->runQuery("SELECT * FROM users WHERE u_Email=:email_id");
	$result->execute(array(":email_id" => $email));
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$password = crypt($password, $salt);
	$stmt = $new_msg->runQuery("UPDATE users SET u_Name = :username, u_Email = :email, u_Pass = :password  where u_ID = $userid");
	$stmt->bindparam(":username", $username);
	$stmt->bindparam(":email", $email);
	$stmt->bindparam(":password", $password);
	$stmt->execute();
	$stmt->execute();

}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="resources/css/style.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Login</title>
</head>

<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://www.oulucoders.com">Oulu Coders</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="dashboard.php">Dashboard</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="profile.php">Profile</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="jumbotron">
			<h2><?php echo $row['u_Name']; ?>! You can change your personal information here.</h2>
		</div>
		<div class="row">
			<div class="col-sm-6 user_info col-sm-offset-1">
				<form class="form-signin" method="post">

					<div class="form-group">
						<label for="inputName" class="sr-only">Name</label>
						<input type="text" class="form-control" placeholder="<?php echo $row['u_Name']; ?>" name="input_name" required>
						<i class="fa fa-user"></i>
					</div>

					<div class="form-group">
						<label for="inputEmail" class="sr-only">Email address</label>
						<input type="email" class="form-control" placeholder="<?php echo $row['u_Email']; ?>" name="input_email" required>
						<i class="fa fa-envelope"></i>

					</div>

					<div class="form-group">
						<label for="inputPassword" class="sr-only">Password</label>
						<input type="password" class="form-control" placeholder="Password" name="input_password" required>
						<i class="fa fa-lock"></i>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-signup">Save</button>


				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>
