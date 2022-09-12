<?php
session_start();
include("connect.php");

//restrict access to only logged in users
if (strlen($_SESSION['admin']) == 0) {
    header('location:login.php');
}

$id = $_SESSION['adminid'];
$fullname = $_SESSION['fullname'];
$username = $_SESSION['username'];
$email = $_SESSION['admin'];
$pnumber = $_SESSION['pnumber'];
$msg = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloomReader</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>

<body>
    <!-- navbar -->
    <div class="navbar navbar-fixed-top">
        <?php include("admin-navbar.php"); ?>
    </div>
    <!-- /navbar -->
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="sidebar">

                        <?php include("admin-sidebar.php"); ?>

                    </div>
                    <!--/.sidebar-->
                </div>
                <!--/.span3-->

                <div class="row pull-left offset1">
                    <?php echo $_SESSION['msg'];
                    $_SESSION['msg'] = "";
                    ?>

                </div>


                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>All Members</h3>
                            </div>
                            <div class="module-option clearfix">
                                <form>
                                    <div class="input-append pull-left">
                                        <input type="text" class="span3" placeholder="Filter by name...">
                                        <button type="submit" class="btn">
                                            <i class="icon-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="btn-group pull-right" data-toggle="buttons-radio">
                                <button class="btn btn-small pull-right"><a href="clients_table.php">View Client Table</button></a>
                                </div>
                            </div>
                            <div class="module-body">
                                <div class="row">
                                    <?php
                                    $sql = "SELECT * from clients";
                                    $result = $conn->query($sql);
                                    $clients = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                    ?>
                                    <?php foreach ($clients as $client) : ?>
                                            <div class="media span4 user module bg-light">
                                                <a class="media-avatar pull-left" href="client.php?cid=<?php echo $client['ID'] ?>">
                                                    <img src="images/user.png">
                                                </a>
                                                <div class="media-body">
                                                    <h3 class="media-title">
                                                        <?php echo $client['FNAME'] . ' ' . $client['LNAME']; ?>
                                                    </h3>
                                                    <p>
                                                        <small class="muted">
                                                            <?php
                                                            echo $client['RegDATE']. " <br>";
                                                            if ($client['STATUS'] == 1) {
                                                                echo ("Active");
                                                            }
                                                            if ($client['STATUS'] == 0) {
                                                                echo ("Blocked");
                                                            };
                                                            ?>
                                                        </small>
                                                    </p>

                                                    <div class="media-option btn-group shaded-icon">
                                                        <button class="btn btn-small">
                                                            <a href="client.php?cid=<?php echo $client['ID'] ?>"><i class="icon-share-alt"></i></a>
                                                        </button>
                                                        <button class="btn btn-small">
                                                            <i class="icon-envelope"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    <?php endforeach; ?>
                                </div>

                                <div class="row pagination pagination-centered">
                                    <ul>
                                        <li><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.content-->
                </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
    <div class="footer">
        
    </div>
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
</body>