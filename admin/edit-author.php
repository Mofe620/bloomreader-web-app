<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

if(isset($_POST['update'])){

$id=intval($_GET['authid']);
$author = mysqli_escape_string($conn, $_POST['AutName']);

$sql ="UPDATE authors SET `AuthorName` = '$author', `LastUPDATED` = NOW() WHERE ID = '$id' ";
        if ($conn->query($sql) === TRUE) {

        $_SESSION['msg'] = '<div class="alert alert-success"><strong>Success: </strong>Author has been updated.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:authors.php');

    } else {
    	$_SESSION['msg'] = '<div class="alert alert-error"><strong>Error: </strong>Author could not be updated.
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
				  
				   <!--EDIT AUTHOR-->
                   <div class="" id="editAuthor">
					<form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Edit Author</h3>
						</div>
						<?php
						$authid=intval($_GET['authid']);

						$sql1 = "SELECT * FROM AUTHORS WHERE `ID` = '$authid' ";
						$result = $conn->query($sql1);
                            while($row = mysqli_fetch_assoc($result)) {
                                 $author =  $row['AuthorName'];
                             }
						?>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">Author Name</label>
									<input class="span12" name="AutName" type="text" id="AutName" value="<?php echo $author; ?>" required>
								</div>
							</div>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label"><strong>Books</strong></label>
									<?php
									$sql2 = "SELECT `BookName` FROM BOOKS WHERE `AuthorID` = '$authid' ";
									$result = $conn->query($sql2);
			                            while($row = mysqli_fetch_assoc($result)) {
			                                $books =  $row['BookName'];
			                            	echo $books.'<br>'; 
			                            }
		                            if(mysqli_num_rows($result)==0){echo ("No books registered for this Author");}?>		
								</div>
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