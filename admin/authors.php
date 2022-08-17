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

$sql ="DELETE from authors WHERE `ID` = '$id' ";
        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Author has been deleted.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
				

    } else {
    	$msg = '<div class="alert alert-error"><strong>Error: </strong>Author could not be deleted.
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


				<div class="span9">
					<div class="content">

						<div class="module">
							<div class="module-head">
								<h3>News Feed</h3>
							</div>
							<div class="module-body">
								<div class="stream-composer media">
									<a href="#" class="media-avatar medium pull-left">
										<img src="images/user.png">
									</a>
									<div class="media-body">
										<div class="row-fluid">
											<textarea class="span12" style="height: 70px; resize: none;"></textarea>
										</div>
										<div class="clearfix">
											<a href="#" class="btn btn-primary pull-right">
												Update Status
											</a>
											<a href="#" class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="Upload a photo">
												<i class="icon-camera shaded"></i>
											</a>
											<a href="#" class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="Upload a video">
												<i class="icon-facetime-video shaded"></i>
											</a>
											<a href="#" class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="Pin your location">
												<i class="icon-map-marker shaded"></i>
											</a>
										</div>
									</div>
								</div>
							</div><!--/.module-body-->
						</div><!--/.module-->

					</div><!--/.content-->
				</div><!--/.span9-->


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
	                            <li class="active"><a href="#bookAuthors" data-toggle="tab">Book Authors</a></li>
	                            <li><a href="#manageAuthors" data-toggle="tab">Manage Authors</a></li>
	                        </ul>
                    	</div>

                	<div class="tab-content">


                        <div class="module tab-pane fade active in" id="bookAuthors">
                            <div class="module-head">
                                <h3>Book Authors</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" id="dataTables-example" class="table table-bordered table-striped datatable"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">S/N</th>
                                            <th style="text-align: center;">Author</th>
                                            <th style="text-align: center;">Books</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>

                                    <?php
                                        $serial = 1;
                                        $sql = "SELECT authors.AuthorName, books.AuthorID, 
                                        GROUP_CONCAT( books.BookName SEPARATOR ' <br> ' ) AS BookName FROM BOOKS join AUTHORS on books.AuthorID = authors.ID group BY authors.AuthorName order by authors.ID ";
                                        $result = $conn->query($sql);
                                        while($row = mysqli_fetch_assoc($result)) {
                                        	 $authid =  $row['AuthorID'];
                                             $books =  $row['BookName'];
                                             $author =  $row['AuthorName'];
                                    ?>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td style="text-align: center;"><?php echo $serial; ?></td>
                                            <td><b><?php echo $author; ?></b></td>
                                            <td style="text-align: center;"><?php echo $books; ?></td>
                                            <td style="text-align: center;"><a href="edit-author.php?authid=<?php echo $authid ?>"><button class="btn btn-primary"><i class="icon-pencil "></i> Edit</button> 
                                         	 <a href="authors.php?del=<?php echo $authid; ?>" onclick="return confirm('Are you sure you want to delete this author?');" >  <button class="btn btn-danger"><i class="icon-trash"></i> Delete</button>
                                         	</td>
                                        </tr>
                                    </tbody>
                                    <?php $serial++;
                                        } ?>
                                </table>
                            </div>
                        </div><!--/.module--> 


                        <div class="module tab-pane fade in" id="manageAuthors">
                            <div class="module-head">
                                <h3>All Authors</h3>
                                <a href="add-author.php"><button class="btn btn-info pull-right">Add Author</button></a>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" id="dataTables-example" class="table table-bordered table-striped datatable"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">S/N</th>
                                            <th style="text-align: center;">Author</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>

                                    <?php
                                        $serial = 1;
                                        $sql = "SELECT * FROM authors order by authors.ID ";
                                        $result = $conn->query($sql);
                                        while($row = mysqli_fetch_assoc($result)) {
                                        	 $authid =  $row['ID'];
                                             $author =  $row['AuthorName'];
                                    ?>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td style="text-align: center;"><?php echo $serial; ?></td>
                                            <td><b><?php echo $author; ?></b></td>
                                            <td style="text-align: center;"><a href="edit-author.php?authid=<?php echo $authid ?>"><button class="btn btn-primary"><i class="icon-pencil "></i> Edit</button> 
                                         	 <a href="authors.php?del=<?php echo $authid; ?>" onclick="return confirm('Are you sure you want to delete this author?');"" >  <button class="btn btn-danger"><i class="icon-trash"></i> Delete</button>
                                         	</td>
                                        </tr>
                                    </tbody>
                                    <?php $serial++;
                                        } ?>
                                </table>
                            </div>
                        </div><!--/.module--> 


                    </div><!--/.tab-content-->

                    </div><!--/.content-->
                </div><!--/.span-->


			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
			 

			<b class="copyright">&copy; 2014 BloomReader - EGrappler.com </b> All rights reserved.
		</div>
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