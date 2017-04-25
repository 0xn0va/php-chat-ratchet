<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style type="text/css">
    * {
        box-sizing: border-box;
    }

    body {
        min-height: 800px;
        padding-top: 70px;
        font-size: 16px;
        background-color: #edeff2;
        font-family: "Calibri", "Roboto", sans-serif;
    }

    .avatar {
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background-color: #de2a3d;
    }

    .user_info {
        padding: 15px;
        border-radius: 6px;
        background-color: #f8f8f8;
    }

    .online_status {
        display: inline-block;
        width: calc(100% - 85px);
        min-width: 150px;
        height: 50px;
        border-radius: 20px;
        background-color: #edeff2;
        text-align: center;
        border: 1px solid #bcbdc0;
        line-height: 48px;
        font-size: 18px;
        font-weight: 300;
    }

    .btn-save {
        width: 140px;
        height: 50px;
        display: inline-block;
        color: #edeff2;
        background-color: #de2a3d;
        border-radius: 50px;
        border: 2px solid #edeff2;
        cursor: pointer;
        transition: all 0.2s linear;
        text-align: center;
        float: right;
        line-height: 2.8;
    }

    .btn-save:hover {
        background-color: #edeff2;
        color: #de2a3d;
        border-color: #de2a3d;
    }
    </style>
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
                    <li><a href="dashboard_edited.html">Dashboard</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="avatar"></div>
            </div>
            <div class="col-sm-6 user_info col-sm-offset-1">
                <ul>User Info:<br>
                    <li class="online_status">
                    </li>
                    <li class="online_status">
                    </li>
                    <li class="online_status">
                    </li>
                    <li class="online_status">
                    </li>
                </ul>
                <div class="btn-save">Save</div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>
