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
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
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

		<style>
				.chatbox {
			height: 200px;
			overflow: auto;
			border: 1px solid darkgrey;
			background: white;
			border-radius: 5px; }
				.chatcontainer {
			height: 500px;
			background: blue;
			width: 70%;
			float: left;
			margin-left: auto;
			margin-right: auto; }
				.toolscontainer {
			height: 500px;
			background: green;
			width: 29%;
			float: right;
			margin-left: auto;
			margin-right: auto; }
				.selectchannel {
			width: 100%;
			height: 30%;
			background: red; }
				#newmsg {
			width: 90%; }
				.sendbtn {
			width: 9%; }

				.timestamp {
			font-size: 16px;
			padding-right: 5px;
			padding-left: 5px;
			background: #AAAAAA;
			display: inline-block;
			width: 10%;
			color: #666666;}
				.username {
			font-weight: bold;
			font-size: 16px;
			background: #999999;
			display: inline-block;
			width: 90%;
			padding-right: 5px;}
				.msg {
			background: #CCCCCC;
			width: 100%;
			font-size: 18px;
			padding-left: 10px;}
		</style>

</head>
<body onLoad="StartChat ()">
<div>
  <div>
     <div class="container-fluid">
        <nav class="navbar navbar-default navbar-static-top">
            <a class="navbar-brand" href="#">Dashboard</a>
            <p class="navbar-text navbar-left">Hello,

                <?php echo $row['u_Name']; ?>, your email is <?php echo $row['u_Email']; ?>
                and you're verified, Thank you.

            </p>
            <a href="logout.php">
                <button class="btn btn-danger">Logout</button>
            </a>
        </nav>

<div class="chatcontainer">
				<div id="chatbox" class="chatbox"></div>
				<form action="" method="post">
					<input id="newmsg">
					<input type="button" value="Send" onclick="sendMsg()">
				</form>
</div>

<div class="toolscontainer">
				<!--This is the piece of code for changing the current room,
				but I cannot figure out the way to make it work while running
				the current session. I'm also going to add the function, which
				will update the list of rooms. -->
				<div class="selectchannel">
				<form action="" method="post">
					<select size="3" name="channelbox" id="channelbox">
    				<option disabled>Choose the chat room</option>
   					<option value="room1">1</option>
    				<option value="room2">2</option>
   				</select><br>
   			  <button onclick="">Go</button>
				</form>
				</div>
</div>



        </div>
    </div>
</div>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
