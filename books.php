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
    <style>
        .module-body {
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
				</div><!--/.span3-->

				<div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-head">
                                <h3>Search Books in Library</h3>
                            </div>
                            <div class="module-body">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped"
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
                                            <td style="text-align: center;"><?php echo $book; ?></td>
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
                        </div>
                        <!--/.module-->
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
	<script src="scripts/common.js" type="text/javascript"></script>
</body>