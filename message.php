<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['email'])==0){ 
header('location:login.php');
}

$id=$_SESSION['userid'];
$fname=$_SESSION['fname'];
$lname=$_SESSION['lname'];
$email=$_SESSION['email'];
$pnumber=$_SESSION['pnumber'];
$msg = "";

if(isset($_POST['send'])){

$id = mysqli_escape_string($conn, $_POST['client']);
$subject = mysqli_escape_string($conn, $_POST['subject']);
$message = mysqli_escape_string($conn, $_POST['message']);

$sql ="INSERT into messages (`ClientID`, `Subject`, `Message`, `DateTime`) 
        VALUES ( '$id', '$subject', '$message', NOW() ) ";
        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Message has been sent.
                            <button type="button" class="close" data-dismiss="alert">×</button></div>';

    } else {
        $msg = '<div class="alert alert-error"><strong>Error: </strong>Message could not be sent.
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
    <style>
        .module-body.table {
            overflow: scroll !important;
        }
    </style>
    </head>
    <body>
        <!-- navbar -->
    <div class="navbar navbar-fixed-top">
        <?php include ("navbar.php");?>
    </div>
    <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <!-- sidebar-->
                        <?php include ("sidebar.php");?>
                        <!--/.sidebar-->
                    </div>

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

                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">

                            <div class="module">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="module-head">
                                        <h3>Write Message to Admin</h3>
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
                                                    <input type="submit" name="send" class="btn btn-primary pull-right" value="Send">
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
                                    <table class="table table-message table-responsive">
                                        <tbody>
                                            <thead class="heading" style="color:white; background-color: #29b7d3;">
                                                <th class="cell-check">
                                                    <input type="checkbox" class="inbox-checkbox">
                                                    All
                                                </th>
                                                <th class="cell-icon">
                                                </th>
                                                <th class="cell-author hidden-phone hidden-tablet">
                                                    Subject
                                                </th>
                                                <th class="cell-title">
                                                    Message
                                                </th>
                                                <th class="cell-time align-right">
                                                    Date
                                                </th>
                                                <th class="cell-icon hidden-phone hidden-tablet align-right">
                                                    Status
                                                </th>
                                            </thead>
                                            <?php
                                            $serial = 1;
                                            $sql = "SELECT messages.ID as MID, messages.DateTime, messages.Status, messages.Subject, messages.Message, clients.FNAME, clients.LNAME FROM MESSAGES join clients on messages.ClientID = clients.ID WHERE messages.ClientID = '$id'; ";
                                            $result = $conn->query($sql);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                 $mid =  array($row['MID']);
                                                 $DateTime =  $row['DateTime'];
                                                 $subject =  $row['Subject'];
                                                 $message =  $row['Message'];
                                                 $status =  $row['Status'];
                                                 $fname =  $row['FNAME'];
                                                 $lname =  $row['LNAME'];
                                                
                                        ?>
                                            <tr class="unread starred">
                                                <td class="cell-check">
                                                    <input type="checkbox" class="inbox-checkbox">
                                                </td>
                                                <td class="cell-icon">
                                                    <i class="icon-star"></i>
                                                </td>
                                                <td class="cell-author hidden-phone hidden-tablet">
                                                    <?php echo $subject; ?>
                                                </td>
                                                <td class="cell-title">
                                                    <?php echo $message; ?>
                                                </td>
                                                <td class="cell-time align-right">
                                                    <?php echo $DateTime; ?>
                                                </td>
                                                <?php
                                                 foreach ($mid as $mid) {
                                                 
                                                 $sql1 = "SELECT * FROM ADMIN_RESP WHERE `MessageID` = '$mid' ";
                                                 $result1 = $conn->query($sql1);
                                                 if(mysqli_num_rows($result1)>0){
                                                    while($row = mysqli_fetch_assoc($result1)) {
                                                        $response = $row['Response'];
                                                        $respTime =  $row['RespTime'];
                                                        $rid =  $row['ID'];
                                                        $admin =  $row['ADMIN'];
                                                        $status = "<a data-toggle='modal' data-target=#$rid>View Response</a>";
                                                 }?>
                                                 <div class="modal fade" id="<?php echo $rid; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Response from Admin</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="module-body">
                                                                <p><?php echo $response; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <small><?php echo $respTime; ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else {$status = "No Reply"; $response = ""; $respTime = "";} ?>
                                                <td class="cell-icon hidden-phone hidden-tablet">
                                                    <?php echo $status; ?>
                                                </td>
                                                </tr>
                                        <?php  } $serial++; }?>
                                                
                                            <tr class="unread">
                                                <td class="cell-check">
                                                    <input type="checkbox" class="inbox-checkbox">
                                                </td>
                                                <td class="cell-icon">
                                                    <i class="icon-star"></i>
                                                </td>
                                                <td class="cell-author hidden-phone hidden-tablet">
                                                    John Donga
                                                </td>
                                                <td class="cell-title">
                                                    Something
                                                </td>
                                                <td class="cell-icon hidden-phone hidden-tablet">
                                                    <i class="icon-paper-clip"></i>
                                                </td>
                                                <td class="cell-time align-right">
                                                    22:17
                                                </td>
                                            </tr>
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
