<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

if(isset($_POST['add'])){

$category = mysqli_escape_string($conn, $_POST['catName']);
$status = mysqli_escape_string($conn, $_POST['status']);

$sql ="INSERT into category (`CategoryName`, `STATUS`, `CreationDate`) VALUES ( '$category', '$status', NOW() ) ";
        if ($conn->query($sql) === TRUE) {

        $_SESSION['msg'] = '<div class="alert alert-success"><strong>Success: </strong>Category has been added.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:categories.php');

    } else {
    	$_SESSION['msg'] = '<div class="alert alert-error"><strong>Error: </strong>Category could not be added.
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
				  
				   <!--ADD CATEGORY-->
                   <div class="" id="addCategory">
					<form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Add Category</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">Category Name</label>
									<input class="span12" name="catName" type="text" id="catName"  required>
								</div>
							</div>
							<div class="control-group">
											<label class="control-label">Status</label>
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
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="add" class="btn btn-primary pull-right" value="Add">
								</div>
							</div>
						</div>
					</form>
				   </div>
			                        
				 
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->