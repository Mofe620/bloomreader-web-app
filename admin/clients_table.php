<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

$msg = "";

if(isset($_GET['del'])){

$id=$_GET['del'];

$sql ="DELETE from clients WHERE `ID` = '$id' ";
        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Client record has been deleted from system.
                            <button type="button" class="close" data-dismiss="alert">×</button></div>';
                

    } else {
        $msg = '<div class="alert alert-error"><strong>Error: </strong>Client record could not be deleted.
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

				<div class="row pull-left offset1">
                    <?php echo $msg; ?>
                </div>

            	<div class="span9">
                    <div class="content">

                        <div class="module tab-pane fade active in" id="viewClients">
                            <div class="module-head">
                                <h3>Registered Clients</h3>
                            </div>
                            <div class="module-body table">
                                <table cellpadding="0" cellspacing="0" border="0" id="dataTables-example" class="table table-bordered table-striped datatable"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">S/N</th>
                                            <th style="text-align: center;">Name</th>
                                            <th style="text-align: center;">Email</th>
                                            <th style="text-align: center;">Contact</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>

                                    <?php
                                        $serial = 1;
                                        $sql = "SELECT * FROM CLIENTS";
                                        $result = $conn->query($sql);
                                        while($row = mysqli_fetch_assoc($result)) {
                                        	 $cid =  $row['ID'];
                                             $fname =  $row['FNAME'];
                                             $lname =  $row['LNAME'];
                                             $email =  $row['EMAIL'];
                                             $contact =  $row['PNUMBER'];
                                             $status =  $row['STATUS'];
                                    ?>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td style="text-align: center;"><?php echo $serial; ?></td>
                                            <td><b><a href="client.php?cid=<?php echo $cid; ?> "><?php echo ("$fname $lname"); ?></a></b></td>
                                            <td style="text-align: center;"><?php echo $email; ?></td>
                                            <td style="text-align: center;"><?php echo $contact; ?></td>
                                            <td style="text-align: center;"><?php 
	                                    	if($status == 1){echo ("Active");}
	                                    	if($status == 0){echo ("Blocked");}
	                                    	?></td>
                                            <td style="text-align: center;"><a href="clients_table.php?del=<?php echo $cid; ?>" onclick="return confirm('This will delete this client from the record, completely!');"" ><button class="btn btn-danger"><i class="icon-trash"></i></button></td>
                                        </tr>
                                    </tbody>
                                    <?php $serial++;
                                        } ?>
                                </table>
                            </div>
                        </div><!--/.module-->

                    </div>
                    <!--/.content-->
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