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

if (isset($_POST['btn-save'])) {
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
    <title>Profile</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet prefetch" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto+Slab'>

	<style type="text/css">
		* {
		box-sizing: border-box;
}

body {
		min-height: 800px;
		padding-top: 100px;
		font-size: 16px;
		background-color: #edeff2;
		font-family: "Roboto Slab", "Calibri", sans-serif;
		background-image: url("resources/1.png");
		background-size: cover;
}

a:hover {
		text-decoration: none;
}

.navbar {
		padding: 7px;
		font-size: 18px;
}

.navbar-inverse .navbar-nav li a,
.navbar-inverse .navbar-brand {
		color: #fff;
}

.navbar-inverse .navbar-nav .active a,
.navbar-inverse .navbar-brand:hover,
.navbar-inverse .navbar-nav li a:hover {
		color: #de2a3d;
}

.navbar-toggle {
		background-color: #de2a3d;
		padding: 12px 10px;
}

.navbar-inverse .navbar-toggle:focus,
.navbar-inverse .navbar-toggle:hover {
		background-color: #de2a3d;
}

.user_avatar {
		text-align: center;
}

	.avatar {
			width: 250px;
			height: 250px;
			border-radius: 50%;
			background-color: rgba(109, 42, 93, 0.7);
			display: inline-block;
	}

	.user_info {
			padding: 20px;
			border-radius: 6px;
			background-color: rgba(0, 0, 0, 0.55);
			text-align: center;

	}

	.form_heading {
			text-align: center;
			font-size: 20px;
			padding: 10px 0 20px 0px;
			color: rgba(256, 256, 256, 0.9);
	}

	.form-signin {
	}

	 .form-group {
	  position: relative;
	  margin-bottom: 13px;
	}

    .form-group .fa {
      position: absolute;
      right: 60px;
      top: 17px;
      color: #999;
}

/*.user_fields {
		list-style: none;
		padding-left: 0px;
}*/



.user_field {
		display: inline-block;
		width: calc(100% - 85px);
		min-width: 150px;
		border-radius: 20px;
		font-size: 16px;
		text-align: center;
		line-height: 48px;
		height: 45px;
		background-color: #edeff2;
		border: 2px solid #de2a3d;
		
}



.btn-save {
		width: 140px;
		height: 50px;
		display: inline-block;
		color: #edeff2;
		background-color: #de2a3d;
		border-radius: 50px;
		border: 2px solid #bcbdc0;
		cursor: pointer;
/*		transition: all 0.2s linear;
*/		text-align: center;
		float: right;
		line-height: 2.8;
		margin-top: 10px;
}

.btn-save:hover {
		background-color: #edeff2;
		color: #de2a3d;
		border-color: #de2a3d;
}


/*Media styles*/
@media only screen and (max-width: 568px) {
		.user_info {
				margin-top: 10px;
		}
		/* .user_info .user_field {
				width: calc(100% - 50px);
		}
</style>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
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

		<div class="row">
			<div class="col-sm-4 col-sm-offset-1">
		<div class="user_avatar">
				<div class="avatar"></div>
		</div>
</div>
			<div class="col-sm-5 col-sm-offset-1 user_info">
			<div class="form_heading">User Info:</div>
				<form class="form-signin" method="post">

					<div class="form-group">
						<label for="inputName" class="sr-only">Name</label>
						<input type="text" class="form-control user_field" placeholder="<?php echo $row['u_Name']; ?>" name="input_name" required>
						<i class="fa fa-user"></i>
					</div>

					<div class="form-group">
						<label for="inputEmail" class="sr-only">Email address</label>
						<input type="email" class="form-control user_field" placeholder="<?php echo $row['u_Email']; ?>" name="input_email" required>
						<i class="fa fa-envelope"></i>

					</div>

					<div class="form-group">
						<label for="inputPassword" class="sr-only">Password</label>
						<input type="password" class="form-control user_field" placeholder="Password" name="input_password" required>
						<i class="fa fa-lock"></i>
					</div>

					<button class="btn-save" type="submit" name="btn-save">Save</button>


				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>
