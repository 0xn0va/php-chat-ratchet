<?php
session_start();
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
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title><?php echo $row['u_Email']; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="resources/css/style.css" rel="stylesheet" media="screen">
	<script src="ratchat/ajax.js" type="text/javascript"></script>
	<script src="ratchat/ratax.js" type="text/javascript"></script>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script>
	var chat = new RatChat();
	function StartChat () {
		chat.setInput( document.getElementById('newmsg') );
		chat.setOutput( document.getElementById('chatbox') );
		chat.setNick( '<?php echo $row['u_Name']; ?>');
		chat.setChannel('room1');
		chat.startPolling();
	}
	</script>
</head>
<body onLoad="StartChat ()">
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
					<li class="active"><a href="dashboard.php">Dashboard</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="profile.php">Profile</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="jumbotron">
			<h2>Hello, <?php echo $row['u_Name']; ?>! How are you today?</h2>
		</div>
		<div class="row">
			<div class="col-sm-8 chat_window">
				<div class="bottom_wrapper clearfix">
					<div class="messages">
						<div id="chatbox" class="chatbox"></div>
						<form action="" method="post">
							<input id="newmsg">
							<input type="button" value="Send" onclick="sendMsg()">
						</form>
					</div>
				</div>
			</div>

			<!-- <div class="col-sm-3  col-sm-offset-1 sidebar">
				<ul class="users">
					<li class="online">
						<div class="online_status">Room 1</div>
			                     </li>
					<li class="online">
						<div class="online_status">Room 2</div>
			                  </li>
					<li class="online">
						<div class="online_status">Room 3</div>
	                  </li>
					<li class="online">
						<div class="online_status">Room 4</div>
			                  </li>

				</ul>

			</div> -->
			<div class="toolscontainer col-sm-3  col-sm-offset-1 sidebar">
			 <div >
				 <h3>Choose a chat room</h3>
				 <form action="" method="post">
					 <select size="3" name="channelbox" id="channelbox" class="online">
						 <option value="room1" class="online_status">Room 1</option>
						 <option value="room2" class="online_status">Room 2</option>
					 </select><br>
					 <button onclick="">Go</button>
				 </form>
			 </div>
		 </div>


									<a href="#" onClick="window.open('upload.php','Upload','resizable,height=560,width=670'); return false;"><button type="button" class="btn btn-primary active">Upload</button></a><noscript>You need Javascript to use the previous link or use <a href="upload.php" target="_blank"><button type="button" class="btn btn-primary active">Upload</a></noscript>

										<a href="#" onClick="window.open('files.php','Files','resizable,height=560,width=670'); return false;"><button type="button" class="btn btn-primary active">Download</button></a><noscript>You need Javascript to use the previous link or use <a href="files.php" target="_blank"><button type="button" class="btn btn-primary active">Download</a></noscript>


	</div>
	</div>
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- <script type="text/javascript" src="chat.js"></script> -->
</body>
</html>
