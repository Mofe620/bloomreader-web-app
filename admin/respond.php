<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

if(isset($_POST['send'])){

$re = "Admin";
$mid=intval($_GET['mi']);
$response = mysqli_escape_string($conn, $_POST['response']);
$cid = mysqli_escape_string($conn, $_POST['cid']);

$sql ="INSERT INTO ADMIN_RESP (`ADMIN`, `ClientID`, `MessageID`, `Response`, `RespTime`) 
		VALUES ('$re', '$cid', '$mid', '$response', NOW() )";
        if ($conn->query($sql) === TRUE) {

$sql3 = "UPDATE MESSAGES SET STATUS = 1 WHERE ID = '$mid' ";
		 if ($conn->query($sql3) === TRUE) {
        $_SESSION['msg'] = '<div class="alert alert-success"><strong>Success: </strong>Reply has been sent.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:message.php');

    }

}else {
    	$_SESSION['msg'] = '<div class="alert alert-error"><strong>Error: </strong>Reply could not be sent.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:message.php');
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
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
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
					<!-- sidebar-->
                        <?php include ("admin-sidebar.php");?>
                        <!--/.sidebar-->
				</div><!--/.span3-->


				<div class="module module-login span6 offset1 ">
				  
				   <!--EDIT AUTHOR-->
                   <div class="" id="editAuthor">
					<form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Reply Message</h3>
						</div>
						<?php
						$mid=intval($_GET['mi']);

						$sql1 = "SELECT * FROM MESSAGES WHERE `ID` = '$mid' ";
						$result = $conn->query($sql1);
                            while($row = mysqli_fetch_assoc($result)) {
                                 $subject =  $row['Subject'];
                                 $Cmessage =  $row['Message'];
                                 $cid =  $row['ClientID'];
                             }
						?>
						<div class="module-body">
							<div class="control-group">
								<h5>Subject: <?php echo $subject; ?></h5>
								<input name="cid" value="<?php echo $cid; ?>" hidden >
								<textarea class="span3" name="" style="height:100px;  resize: none;" disabled="true"><?php echo $Cmessage; ?></textarea>
							</div>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									
									 		<?php 
									 			$mid=intval($_GET['mi']);
									 			$sql1 = "SELECT * FROM ADMIN_RESP WHERE `MessageID` = '$mid' ";
                                                 $result1 = $conn->query($sql1);
                                                 if(mysqli_num_rows($result1)>0){
                                                    while($row = mysqli_fetch_assoc($result1)) {
                                                        $response = $row['Response'];
                                                        $respTime =  $row['RespTime'];
                                                    }
                                                } else {$response = ""; $respTime = "";}
									 		?>
							 		<label for="name" class="col-form-label"><strong>Reply</strong> -<em><?php echo $respTime ?></em>
							 		</label>
									<textarea class="span12" name="response" style="height: 100px; resize: none;" 
										value=""><?php echo $response;  ?>
									</textarea>		
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="send" class="btn btn-primary pull-right" value="Send">
								</div>
							</div>
						</div>
					</form>
				   </div>
			                        
				 
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

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