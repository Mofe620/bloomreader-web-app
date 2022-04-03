<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

    $id=$_SESSION['adminid'];
    $fullname=$_SESSION['fullname'];
    $username=$_SESSION['username'];
    $email=$_SESSION['admin'];
    $pnumber=$_SESSION['pnumber'];
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
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
</head>
<body>
    <!-- navbar -->
    <div class="navbar navbar-fixed-top">
        <?php include ("admin-navbar.php");?>
    </div>
    <!-- /navbar -->
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="sidebar">

                            <?php include ("admin-sidebar.php");?>

                        </div><!--/.sidebar-->
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
                                <button class="btn btn-small pull-right"><a href="clients_table.php">View Client Table</button>
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
                                    <button type="button" class="btn">
                                        All</button>
                                    <button type="button" class="btn">
                                        Male</button>
                                    <button type="button" class="btn">
                                        Female</button>
                                </div>
                            </div>
                            <div class="module-body">
                                <div class="row">
                                        <?php
                                            $sql = "SELECT * from clients";
                                            $result = $conn->query($sql);
                                              
                                               while($row = mysqli_fetch_assoc($result)) { 
                                                    $Cfname =$row['FNAME'];
                                                    $Clname =$row['LNAME'];
                                                    $Cnumber =$row['PNUMBER'];
                                                    $Cstatus= $row['STATUS'];
                                                    $Cemail= $row['EMAIL'];
                                                    $joined=$row['RegDATE'];
                                                    $cid =$row['ID'];
                                        ?>
                                    <div class="span3 offset1">
                                        <div class="media user module bg-light">
                                            <a class="media-avatar pull-left" href="client.php?cid=<?php echo $cid ?>">
                                                <img src="images/user.png">
                                            </a>
                                            <div class="media-body">
                                                <h3 class="media-title">
                                                    <?php echo $Cfname.' '.$Clname; ?>
                                                </h3>
                                                <p>
                                                    <small class="muted">
                                                    <?php 
                                                    echo "$joined<br>";
                                                    if($Cstatus == 1){echo ("Active");}
                                                    if($Cstatus == 0){echo ("Blocked");}; 
                                                    ?>
                                                    </small></p>

                                                <div class="media-option btn-group shaded-icon">
                                                    <button class="btn btn-small">
                                                    <a href="client.php?cid=<?php echo $cid ?>"><i class="icon-share-alt"></i>
                                                    </button>
                                                    <button class="btn btn-small">
                                                        <i class="icon-envelope"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!--/.row-fluid-->
                                <br/><br>
                                
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
        <div class="container">
            <b class="copyright">&copy; 2014 BloomReader - EGrappler.com </b>All rights reserved.
        </div>
    </div>
    <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
</body>
