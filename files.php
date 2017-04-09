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
    <div>
  <table class="table" >
    <!-- <tr>
      <th >All The Files</th>
    </tr> -->
    <tr>
      <td>Uploader</td>
      <td>File Name</td>
      <td>Type</td>
      <td>Size/KB</td>
      <td>Download</td>
    </tr>

    <?php
    //TODO need to upload queries accoring new database
    $sql1="SELECT * FROM dbp_files";
    $result1=mysql_query($sql1);
    while($row=mysql_fetch_array($result1))
    {
      $userid = $row['user_id'];
      $sql2="SELECT name from dbp_users where id = '$userid'";
      $result2=mysql_query($sql2);
      $row2=mysql_fetch_array($result2);

      ?>
      <tr>
        <td><?php echo $row2['name'] ?></td>
        <td><?php echo $row['file'] ?></td>
        <td><?php echo $row['type'] ?></td>
        <td><?php echo $row['size'] ?></td>
        <td><a href="uploads/<?php echo $row['file'] ?>" target="_blank">Click</a></td>
      </tr>
      <?php
    }
    ?>
  </table>
</div>

</div>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
