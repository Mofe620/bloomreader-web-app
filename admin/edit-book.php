<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

if(isset($_POST['update'])){

$id=intval($_GET['bookid']);
$bookName = mysqli_escape_string($conn, $_POST['bookName']);
$author = mysqli_escape_string($conn, $_POST['author']);
$isbn = mysqli_escape_string($conn, $_POST['isbn']);
$price = mysqli_escape_string($conn, $_POST['price']);
$category = mysqli_escape_string($conn, $_POST['category']);
$status = mysqli_escape_string($conn, $_POST['status']);

$sql ="UPDATE books SET `BookName` = '$bookName', `ISBN` = '$isbn', `AuthorID` = '$author', `CategoryID` = '$category', `PRICE` = '$price', `STATUS` = '$status', `LastUPDATED` = NOW() WHERE ID = '$id' ";
        if ($conn->query($sql) === TRUE) {

        $_SESSION['msg'] = '<div class="alert alert-success"><strong>Success: </strong>Book has been updated.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:books.php');

    } else {
    	$_SESSION['msg'] = '<div class="alert alert-error"><strong>Error: </strong>Book could not be updated.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
        header('location:books.php');
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
				  
				   <!--EDIT BOOK-->
                   <div class="" id="editBook">
					<form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Update Book Info</h3>
						</div>
						<?php
						$bookid=intval($_GET['bookid']);

						$sql1 = "SELECT books.BookName, books.ISBN, books.PRICE, books.STATUS, authors.AuthorName, authors.ID as AID, category.ID as CID, category.CategoryName FROM BOOKS join AUTHORS on books.AuthorID = authors.ID join CATEGORY on books.CategoryID = category.ID where books.ID = '$bookid' ";
						$result = $conn->query($sql1);
                            while($row = mysqli_fetch_assoc($result)) {
                            	 $AID =  $row['AID'];
                            	 $CID =  $row['CID'];
                                 $book =  $row['BookName'];
                                 $author =  $row['AuthorName'];
                                 $isbn =  $row['ISBN'];
                                 $category =  $row['CategoryName'];
                                 $price =  $row['PRICE'];
                                 $status =  $row['STATUS'];
                             }
						?>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">Book Name</label>
									<input class="span12" name="bookName" type="text" id="catName" value="<?php echo $book; ?>" required>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="basicinput">Author</label>
								<div class="controls">
									<select name="author" tabindex="1" data-placeholder="Select author" class="span2">
										<option value="<?php echo $AID; ?>"><?php echo $author; ?></option>
										<?php 
										$count = 1;
								        $sql3 = 'SELECT * from authors';
                                        $result = mysqli_query($conn, $sql3);
                                        if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) { 
										?>
										<option value="<?php echo $row['ID']?>" required><?php echo $row['AuthorName']?><br>
										<?php
 
                                        $count++;
 
                                        }
										}
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">ISBN</label>
									<input class="span12" name="isbn" type="text" id="catName" value="<?php echo $isbn; ?>" required>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="basicinput">Category</label>
								<div class="controls">
									<select name="category" tabindex="1" data-placeholder="Select author" class="span2">
										<option value="<?php echo $CID; ?>"><?php echo $category; ?></option>
										<?php 
										$count = 1;
								        $sql4 = 'SELECT * from category';
                                        $result = mysqli_query($conn, $sql4);
                                        if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) { 
										?>
										<option value="<?php echo $row['ID']?>" required><?php echo $row['CategoryName']?><br>
										<?php
 
                                        $count++;
 
                                        }
										}
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="name" class="col-form-label">Price</label>
									<input class="span12" name="price" type="number" id="catName" value="<?php echo $price; ?>" required>
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
													Available
												</label> 
												<label class="radio">
													<input type="radio" name="status" id="" value="0">
													Unavailable
												</label>
											</div>
										<?php } else {
											?>
											<div class="controls">
												<label class="radio">
													<input type="radio" name="status" id="" value="1">
													Available
												</label> 
												<label class="radio">
													<input type="radio" name="status" id="" value="0" checked="checked">
													Unavailable
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