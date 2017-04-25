<?php
session_start();
require_once 'uploading.php';
require_once 'main.php';
$user_home = new main();
if (!$user_home->is_logged_in()) {
	$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM users WHERE u_ID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<title><?php echo $row['u_Email']; ?></title>
	<link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="resources/css/style.css" rel="stylesheet" media="screen">
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<div>
		<div>
			<div class="container-fluid">
				<nav class="navbar navbar-default navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="http://www.oulucoders.com">Oulu Coders</a>
						</div>
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#">Dashboard</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="profile.html">Profile</a></li>
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<div>
			<form action="uploading.php" method="post" enctype="multipart/form-data">
				<input type="file" name="file" /><br />
				<button type="submit" name="btn-upload">Upload</button>
			</form>
			<br /><br />
			<?php
			if(isset($_GET['success']))
			{
				?>
				<h3>It was a success ;) your file uploaded!</h3>
				<?php
			}
			else if(isset($_GET['fail']))
			{
				?>
				<h3>Ouch... I am sorry, It failed! :(</h3>
				<?php
			}
			else
			{
				?>
				<h3></h3>
				<?php
			}
			?>
		</div>
	</div>
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="chat.js"></script> --></body>
</html>
