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

$userEmail = $row['u_Email'];

$gravatarUrlNav = $user_home->get_gravatar($userEmail, $s = 46, $d = 'mm');
?>

<!doctype html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row['u_Email']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto+Slab'>
    <link rel="stylesheet" type="text/css" href="resources/css/chat_edited.css">

    <script src="ratchat/ajax.js" type="text/javascript"></script>
    <script src="ratchat/ratax.js" type="text/javascript"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script>
        var chat = new RatChat();
        var chname = 'room1';

        function SelectRoom () {
            var channelbox = document.getElementById('channelbox');
            chname = channelbox.options[channelbox.selectedIndex].value;
            alert("You are entering this room: "+chname);
            StartChat();
            channelbox.disabled=true;
        }

        function StartChat () {
            chat.setInput( document.getElementById('newmsg') );
            chat.setOutput( document.getElementById('messages') );
            chat.setNick( <?php echo $row['u_Name']; ?>);
            chat.setChannel(chname);
            chat.startPolling();
        }

        function AddRoom () {
            var newroominput = document.getElementById('newroomname');
            var newroom = newroominput.value;
            var sysmsg = "Welcome to the room "+newroom+". Enjoy.";
            alert("You have just created new room: "+newroom+".");
            chat.addRoom(newroom, sysmsg);
            newroominput.value = "";
            window.location.reload();
        }
    </script>


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 800px;
            padding-top: 70px;
            font-size: 16px;
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

        .jumbotron {
            padding-top: 10px;
            padding-bottom: 15px;
            padding-left: 15px !important;
            margin-bottom: 15px;
            background-color: transparent;
            color: rgba(256, 256, 256, 0.8);
        }

        .jumbotron h2 {
            margin-bottom: 10px;
        }

        .chat_window {
            padding: 0px;
        }

        .sidebar {
            padding: 10px;
            border-radius: 6px;
            background-color: rgba(0, 0, 0, 0.55);
        }

        #selectchannel h3 {
            text-align: center;
            font-size: 20px;
            padding: 0px 0 20px 0px;
            color: rgba(256, 256, 256, 0.9);
        }

        .sidebar .rooms {
            list-style: none;
            padding-left: 0px;
        }

        .sidebar .room {
            width: calc(100% - 10px);
            min-width: 100px;
            max-width: 200px;
            border-radius: 10px;
            background-color: #de2a3d;
            text-align: center;
            border: 2px solid #bcbdc0;
            cursor: pointer;
            text-decoration: none;
            padding: 0 10px 10px;
            margin: 0 auto 7px;
        }

        .sidebar .text_wrapper {
            line-height: 48px;
            font-size: 18px;
        }

        .sidebar a {
            color: #edeff2;
        }

        .bottom {
            margin-top: 20px;
            min-height: 100px;
            text-align: center;
        }

        .bottom .buttons {
            width: 115px;
            display: inline-block;
            border-radius: 20px;
            background-color: #de2a3d;
            border: 2px solid #bcbdc0;
            color: #edeff2;
            cursor: pointer;
            text-align: center;
            clear: both;
            padding: 10px;
        }

        .bottom .text_wrapper {
            line-height: 25px;
            font-size: 16px;
        }

        .sidebar .rooms .room:hover,
        .bottom .buttons:hover {
            background-color: rgba(237, 239, 242, 0.9);
            ;
            border-color: #de2a3d;
            color: #de2a3d;
        }
        /*Media styles*/

        @media only screen and (max-width: 568px) {
            .sidebar {
                margin-top: 15px;
            }
            .sidebar .room {
                width: calc(100% - 50px);
            }
        }
    /* @media only screen and (orientation: landscape) {
        .sidebar {
            margin-top: 10px;
        }
    }*/


    /*Styles from Abdo*/

    #newmsg { /*new message styling, could borrow from messages*/
        width: 90%;
    }

    .timestamp { /*Not used yet?*/
        font-size: 16px;
        padding-right: 5px;
        padding-left: 5px;
        background: #AAAAAA;
        display: inline-block;
        width: 10%;
        color: #666666;
    }

    .username { /*Not used yet?*/
        font-weight: bold;
        font-size: 16px;
        background: #999999;
        display: inline-block;
        width: 90%;
        padding-right: 5px;
    }


    .msg { /*Not used yet?*/
        background: #CCCCCC;
        width: 100%;
        font-size: 18px;
        padding-left: 10px;
    }

    .selectchannel {
        padding: 5%;
        text-align: center;
        border: 1px solid darkgrey;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .addroom {

        padding: 5%;
        text-align: center;
        border: 1px solid darkgrey;
        border-radius: 5px;

    }

.channelbox {
    width: 80%;
    font-size: 16px;
    border: 1px solid darkgrey;
    border-radius: 5px;
}

</style>
</head>

<body onLoad="chat.getRooms ();">
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
                    <li class="active"><a href="dashboard.php">Dashboard</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
									<li><img src="<?php echo $gravatarUrlNav; ?>" alt="Avatar"></li>
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
                <div class="top_menu">
                    <div class="title">Chat</div>
                </div>

                <div class="messages" id="messages"> <!-- Is it better to keep it as ul, so new messages can be pushed as li's?? -->

                </div>
                >

                <div class="bottom_wrapper clearfix">

                    <form action="" method="post">
                        <div class="message_input_wrapper">
                            <input id="newmsg" class="message_input" placeholder="Type your message here..." />
                        </div>


                        <button class="send_message" onclick="chat.sendMsg();">Send
                        </button>
                    </form>

                </div>



                <!-- <div class="message_template">
                    <li class="message">
                        <div class="avatar"></div>
                        <div class="text_wrapper">
                            <div class="text"></div>
                        </div>
                    </li>
                </div> -->

            </div>

            <div class="col-sm-3 col-sm-offset-1">
                <div class="sidebar">
                    <div class="selectchannel" id="selectchannel">
                        <h3>Choose the Chat Room:</h3>
                        <button onClick="SelectRoom ()">Go</button>
                    </div>

                    <div class="addroom">
                        <form action="" method="post">
                            <input id="newroomname">
                            <input type="button" value="Create new room" onclick="AddRoom()">
                        </form>
                    </div>                </div>


                    <div class="sidebar bottom">
                        <button class="buttons">
                            <a href="#" onClick="window.open('upload.php','Upload','resizable,height=560,width=670'); return false;"><div class="text_wrapper">Upload file</div>
                            </a><noscript>You need Javascript to use the previous link or use <a href="upload.php" target="_blank"><div class="text_wrapper">Upload file</div></a></noscript>
                        </button>
                        <button class="buttons">
                            <a href="#" onClick="window.open('files.php','Files','resizable,height=560,width=670'); return false;">
                                <div class="text_wrapper">Files List</div>
                            </a><noscript>You need Javascript to use the previous link or use <a href="files.php" target="_blank"><div class="text_wrapper">Files List</div></a></noscript>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js " integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin=" anonymous "></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js " integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa " crossorigin="anonymous "></script>
    <!--     <script type="text/javascript " src="chat.js"></script>
-->
</body>

</html>
