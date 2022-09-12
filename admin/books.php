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


if(isset($_GET['del'])){

$id=$_GET['del'];

$sql ="DELETE from books WHERE `ID` = '$id' ";
        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Book has been deleted.
                            <button type="button" class="close" data-dismiss="alert">×</button></div>';
                

    } else {
        $msg = '<div class="alert alert-error"><strong>Error: </strong>Book could not be deleted.
                            <button type="button" class="close" data-dismiss="alert">×</button></div>';
    //  echo mysqli_error($conn);
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
	<link type="text/css" href="scripts/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <style>
        .module-body {
            overflow: scroll !important;
        }
    </style>
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


                        <div class="nav">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#viewBooks" data-toggle="tab">Books</a></li>
                                <li><a href="#manageBooks" data-toggle="tab">Manage Books</a></li>
                            </ul>
                        </div>

                        <div class="tab-content">

                            <div class="module tab-pane fade active in" id="viewBooks">
                                <div class="module-head">
                                    <h3>View Books in Library</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" id="dataTables-example" class="table table-bordered table-striped datatable"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">S/N</th>
                                                <th style="text-align: center;">Book Name</th>
                                                <th style="text-align: center;">Author</th>
                                                <th style="text-align: center;">Category</th>
                                                <th style="text-align: center;"><em>ISBN</em></th>
                                                <th style="text-align: center;">Status</th>
                                            </tr>
                                        </thead>

                                        <?php
                                            $serial = 1;
                                            $sql = "SELECT books.BookName, authors.AuthorName, category.CategoryName, books.ISBN, books.STATUS FROM BOOKS join AUTHORS on books.AuthorID = authors.ID join CATEGORY on books.CategoryID = category.ID ";
                                            $result = $conn->query($sql);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                 $book =  $row['BookName'];
                                                 $author =  $row['AuthorName'];
                                                 $category =  $row['CategoryName'];
                                                 $isbn =  $row['ISBN'];
                                                 $status =  $row['STATUS'];
                                        ?>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td style="text-align: center;"><?php echo $serial; ?></td>
                                                <td><b><?php echo $book; ?></b></td>
                                                <td style="text-align: center;"><?php echo $author; ?></td>
                                                <td style="text-align: center;"><?php echo $category; ?></td>
                                                <td style="text-align: center;"><?php echo $isbn; ?></td>
                                                <td style="text-align: center;"><?php
                                                 if ($status == 0){echo ("Not available");} 
                                                 if ($status == 1){echo ("Available");} 
                                                 ?></td>
                                            </tr>
                                        </tbody>
                                        <?php $serial++;
                                            } ?>
                                    </table>
                                </div>
                            </div><!--/.module-->


                            <div class="module tab-pane fade in" id="manageBooks">
                                <div class="module-head">
                                    <h3>Manage Books</h3>
                                    <a href="add-book.php"><button class="btn btn-info pull-right">Add Book</button></a>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" id="dataTables-example" class="table table-bordered table-striped datatable"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">S/N</th>
                                                <th style="text-align: center;">Book Name</th>
                                                <th style="text-align: center;">Author</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>

                                        <?php
                                            $serial = 1;
                                            $sql = "SELECT books.ID as ID, books.BookName, authors.AuthorName FROM BOOKS join AUTHORS on books.AuthorID = authors.ID ";
                                            $result = $conn->query($sql);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                 $bookid = $row['ID'];
                                                 $book =  $row['BookName'];
                                                 $author =  $row['AuthorName'];
                                        ?>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td style="text-align: center;"><?php echo $serial; ?></td>
                                                <td><b><?php echo $book; ?></b></td>
                                                <td style="text-align: center;"><?php echo $author; ?></td>
                                                <td style="text-align: center;"><a href="edit-book.php?bookid=<?php echo $bookid; ?>">
                                                    <button class="btn btn-primary"><i class="icon-pencil "></i> Edit</button> 
                                                    <a href="books.php?del=<?php echo $bookid; ?>" onclick="return confirm('Are you sure you want to delete this book?');"" >  <button class="btn btn-danger"><i class="icon-trash"></i> Delete</button></td>
                                            </tr>
                                        </tbody>
                                        <?php $serial++;
                                            } ?>
                                    </table>
                                </div>
                            </div><!--/.module-->

                        </div><!--./tab-content-->
                        
                    </div>
                    <!--/.content-->
                </div>


			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<div class="footer">
		
	</div>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="scripts/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	<script src="scripts/common.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>