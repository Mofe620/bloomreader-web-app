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

if(isset($_POST['broadcast'])){

$admin = "ADMIN";
$subject = mysqli_escape_string($conn, $_POST['subject']);
$message = mysqli_escape_string($conn, $_POST['message']);

$sql ="INSERT into announcements (`ADMIN`, `SUBJECT`, `CONTENT`, `DATE`) 
        VALUES ( '$admin', '$subject', '$message', NOW() ) ";
        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Announcement has been sent.
                            <button type="button" class="close" data-dismiss="alert">×</button></div>';

    } else {
        $msg = '<div class="alert alert-error"><strong>Error: </strong>Announcement could not be sent.
                            <button type="button" class="close" data-dismiss="alert">×</button></div>';
      echo mysqli_error($conn);
    }
}
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

                    <!--DISPLAY MSG -->
                    <div class="span4">
                        <?php 

                        echo $msg;
                        $msg = "";  

                        if(isset($_SESSION['msg'])) { 
                        echo $_SESSION['msg']; }
                        $_SESSION['msg'] = ""; 
                        ?>      
                    </div><br>
                <!--//DISPLAY MSG-->

                
                    <div class="span9">
                        <div class="content">

                            <div class="module">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="module-head">
                                        <h3>BROADCAST ANNOUNCEMENT <em>to all readers</em></h3>
                                    </div>
                                    <div class="module-body">
                                        <div class="stream-composer media">
                                            <a href="#" class="media-avatar medium pull-left">
                                                <img src="images/user.png">
                                            </a>
                                            <div class="media-body">
                                                <div class="control-group">
                                                    <div class="controls row-fluid">
                                                        <label for="name" class="col-form-label"><strong>Subject</strong></label>
                                                        <input class="span3" name="subject" type="text" id="" value="" required>
                                                    </div>
                                                </div>
                                                <div class="row-fluid">
                                                    <label for="name" class="col-form-label"><strong>Detail</strong></label>
                                                    <textarea class="span12" name="message" style="height: 100px; resize: none;"></textarea>
                                                </div>
                                                <div class="clearfix">
                                                    <input name="client" value="<?php echo $id; ?>" hidden >
                                                    <input type="submit" name="broadcast" class="btn btn-primary pull-right" value="Broadcast">
                                                    <a href="#" class="btn btn-small" rel="tooltip" data-placement="top">
                                                        <i class="icon-camera shaded"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-small" rel="tooltip" data-placement="top" >
                                                        <i class="icon-facetime-video shaded"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-small" rel="tooltip" data-placement="top" >
                                                        <i class="icon-map-marker shaded"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--/.module-body-->
                                </form>
                            </div><!--/.module-->


                            <div class="module message">
                                <div class="module-head">
                                    <h3>Messages</h3>
                                </div>
                                <div class="module-option clearfix">
                                    <div class="pull-left">
                                        <div class="btn-group">
                                            <button class="btn">
                                                Inbox</button>
                                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Inbox(11)</a></li>
                                                <li><a href="#">Sent</a></li>
                                                <li><a href="#">Draft(2)</a></li>
                                                <li><a href="#">Trash</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Settings</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="module-body table">
                                    <table class="table table-message">
                                        <tbody>
                                            <thead class="heading" style="color:white; background-color: #29b7d3;">
                                                <th class="cell-check">
                                                </th>
                                                <th class="cell-author hidden-phone hidden-tablet">
                                                    From
                                                </th>
                                                <th class="cell-title">
                                                    Subject
                                                </th>
                                                <th class="cell-icon hidden-phone hidden-tablet">
                                                    Status
                                                </th>
                                                <th class="cell-time align-right">
                                                    Date
                                                </th>
                                            </thead>
                                            <?php
                                            $serial = 1;
                                            $sql = "SELECT messages.DateTime, messages.Subject, messages.Status, messages.Message, messages.ID as MID, clients.FNAME, clients.LNAME FROM MESSAGES join CLIENTS on Clients.ID = messages.ClientID";
                                            $result = $conn->query($sql);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                 $mi =  $row['MID'];
                                                 $DateTime =  $row['DateTime'];
                                                 $subject =  $row['Subject'];
                                                 $message =  $row['Message'];
                                                 $status =  $row['Status'];
                                                 $fname =  $row['FNAME'];
                                                 $lname =  $row['LNAME'];

                                                 $all = array($mi);

                                                 foreach ($all as $mi) {
                                                 
                                                 $sql1 = "SELECT * FROM ADMIN_RESP WHERE `MessageID` = '$mi' ";
                                                 $result1 = $conn->query($sql1);
                                                 if(mysqli_num_rows($result1)>0){
                                                    while($row = mysqli_fetch_assoc($result1)) {
                                                        $response = $row['Response'];
                                                        $respTime =  $row['RespTime'];
                                                        $rid =  $row['ID'];
                                                        $admin =  $row['ADMIN'];
                                                 }
                                             }
                                         }
                                        ?>
                                            <tr class="unread starred">
                                                <td class="cell-check">
                                                    <input type="checkbox" class="inbox-checkbox">
                                                </td>
                                                <td class="cell-author hidden-phone hidden-tablet">
                                                    <?php echo ("$fname $lname"); ?>
                                                </td>
                                                <td class="cell-title">
                                                    <a href="respond.php?mi=<?php echo $mi?>"><?php echo $subject; ?></a>
                                                </td>
                                                <td class="cell-title hidden-phone hidden-tablet">
                                                    <?php 
                                                    if ($status == 1){echo ("<a href='respond.php?mi= $mi'>Reply Sent </a><i class='icon-star'></i>");} 
                                                    if ($status == 0){echo ("Awaiting Reply");} ?>
                                                </td>
                                                <td class="cell-time align-right">
                                                    <?php echo $DateTime; ?>
                                                </td>
                                            </tr>
                                        <?php } $serial++; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="module-foot">
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
    </body>
