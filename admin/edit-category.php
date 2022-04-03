<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

if(isset($_POST['update'])){

$id=intval($_GET['catid']);
$category = mysqli_escape_string($conn, $_POST['catName']);
$status = mysqli_escape_string($conn, $_POST['status']);

$sql ="UPDATE category SET `CategoryName` = '$category', `STATUS` = '$status', `LastUPDATED` = NOW() WHERE ID = '$id' ";
        if ($conn->query($sql) === TRUE) {

        $_SESSION['msg'] = '<div class="alert alert-success"><strong>Success: </strong>Category has been updated.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:categories.php');

    } else {
    	$_SESSION['msg'] = '<div class="alert alert-error"><strong>Error: </strong>Category could not be updated.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:categories.php');
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
				  
				   <!--EDIT CATEGORY-->
                   <div class="" id="editCategory">
					<form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Edit Category</h3>
						</div>
						<?php
						$catid=intval($_GET['catid']);

						$sql1 = "SELECT * FROM CATEGORY WHERE `ID` = '$catid' ";
						$result = $conn->query($sql1);
                            while($row = mysqli_fetch_assoc($result)) {
                                 $category =  $row['CategoryName'];
                                 $status =  $row['STATUS'];
                             }
						?>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">Category Name</label>
									<input class="span12" name="catName" type="text" id="catName" value="<?php echo $category; ?>" required>
								</div>
							</div>
							<div class="control-group">
											<label class="control-label">Status</label>
											<?php 
												if ($status == "1"){
											?>
											<div class="controls">
												<label class="radio">
													<input type="radio" name="status" id="" value="1" checked="checked">
													Active
												</label> 
												<label class="radio">
													<input type="radio" name="status" id="" value="0">
													Inactive
												</label>
											</div>
										<?php } else {
											?>
											<div class="controls">
												<label class="radio">
													<input type="radio" name="status" id="" value="1">
													Active
												</label> 
												<label class="radio">
													<input type="radio" name="status" id="" value="0" checked="checked">
													Inactive
												</label>
											</div>

										<?php } ?>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
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