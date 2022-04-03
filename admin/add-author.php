<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

if(isset($_POST['add'])){

$author = mysqli_escape_string($conn, $_POST['AutName']);

$sql ="INSERT into authors (`AuthorName`, `DateAdded`) VALUES ( '$author', NOW() ) ";
        if ($conn->query($sql) === TRUE) {

        $_SESSION['msg'] = '<div class="alert alert-success"><strong>Success: </strong>Author has been added.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:authors.php');

    } else {
    	$_SESSION['msg'] = '<div class="alert alert-error"><strong>Error: </strong>Author could not be added.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:authors.php');
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
							<h3>Add Author</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">Author Name</label>
									<input class="span12" name="AutName" type="text" id="AutName"  required>
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