<?php


require_once 'main.php';
$user = new main();

if (empty($_GET['id']) && empty($_GET['code'])) {
    $user->redirect('index.php');
}

if (isset($_GET['id']) && isset($_GET['code'])) {
    $id = base64_decode($_GET['id']);
    $code = $_GET['code'];

    $statusY = "Y";
    $statusN = "N";

    $result = $user->runQuery("SELECT u_ID,u_Status FROM users WHERE u_ID=:uID AND verif_Code=:code LIMIT 1");
    $result->execute(array(":uID" => $id, ":code" => $code));
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($result->rowCount() > 0) {
        if ($row['u_Status'] == $statusN) {
            $result = $user->runQuery("UPDATE users SET u_Status=:status WHERE u_ID=:uID");
            $result->bindparam(":status", $statusY);
            $result->bindparam(":uID", $id);
            $result->execute();

            $msg = "
		           <div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>Thanks, You verified! <br />
					  <a href='index.php'>Login here</a></strong>
			       </div>
			       ";
        } else {
            $msg = "
		           <div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>You already verified with us, just chill! ;) <br />
					  <a href='index.php'>Login here</a></strong>
			       </div>
			       ";
        }
    } else {
        $msg = "
		       <div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong> OUCH, we can't find you, subscribe now <br />
			    <a href='subscribe.php'>Signup here</a></strong>
			   </div>
			   ";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Subscription</title>
    <link href="resources/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="resources/css/style.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body id="login">
<div class="container">
    <?php if (isset($msg)) {
        echo $msg;
    } ?>
</div>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
