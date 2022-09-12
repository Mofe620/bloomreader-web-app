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
                    <div class="span9">
                        <div class="content">
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="#" class="btn-box big span4"><i class=" icon-random"></i><b>65%</b>
                                        <p class="text-muted">
                                            Growth</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-user"></i><b>15</b>
                                        <p class="text-muted">
                                            New Users</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-money"></i><b>15,152</b>
                                        <p class="text-muted">
                                            Profit</p>
                                    </a>
                                </div>
                                <div class="btn-box-row row-fluid">
                                    <div class="span12">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <a href="#" class="btn-box small span3"><i class="icon-envelope"></i><b>Messages</b></a>
                                                <a href="#" class="btn-box small span3"><i class="icon-group"></i><b>Clients</b></a>
                                                <a href="#" class="btn-box small span3"><i class="icon-exchange"></i><b>Feedback</b></a>
                                                <a href="#" class="btn-box small span3"><i class="icon-save"></i><b>Total Sales</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/#btn-controls-->
                            <!--/.module-->
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
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="scripts/common.js" type="text/javascript"></script>
      
    </body>
