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
        </div>
    </div>
</div>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
