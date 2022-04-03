<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['admin'])==0){ 
header('location:login.php');
}

$msg = "";

/*Block or Activate Client */
if(isset($_POST['status'])){

$id=intval($_GET['cid']);
$state = mysqli_escape_string($conn, $_POST['state']);

if ($state == 1){

$sql ="UPDATE clients SET `STATUS` = '0' WHERE ID = '$id' ";

} else if ($state == 0){

	$sql ="UPDATE clients SET `STATUS` = '1' WHERE ID = '$id' ";

}
        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Client Status has been changed.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';

    } else {
    	$msg = '<div class="alert alert-error"><strong>Error: </strong>Client Status could not be updated.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
	  echo mysqli_error($conn);
	}
}
//End of Block or Activate


/* ISSUE BOOK TO CLIENT */
if(isset($_POST['issue'])){

$id=intval($_GET['cid']);
$bookid = mysqli_escape_string($conn, $_POST['book']);
$due = mysqli_escape_string($conn, $_POST['returnDate']);

$sql ="INSERT into ISSUEDBOOKS (`BookID`, `ClientID`, `DateIssued`, `DueDate`) VALUES ('$bookid', '$id', NOW(), '$due')";

        if ($conn->query($sql) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Book has been issued to Client.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';

    } else {
    	$msg = '<div class="alert alert-error"><strong>Error: </strong>Book could not be issued to Client.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
	  echo mysqli_error($conn);
	}
}
// END OF ISSUE BOOK


/*RETURN BOOK*/
if(isset($_POST['return'])){

$id=$_POST['retid'];

$sql4 ="UPDATE issuedbooks SET `ReturnStatus` = '1', `ReturnDate` = NOW() WHERE `ID` = '$id' ";
        if ($conn->query($sql4) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Book has been returned.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
				
				

    } else {
    	$msg = '<div class="alert alert-error"><strong>Error: </strong>Book could not be returned.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
	  echo mysqli_error($conn);
	}
}
// END OF RETURN BOOK


/*DELETE RECORD*/
if(isset($_POST['del'])){

$id=$_POST['retid'];

$sql5 ="DELETE from issuedbooks WHERE `ID` = '$id' ";
        if ($conn->query($sql5) === TRUE) {

        $msg = '<div class="alert alert-success"><strong>Success: </strong>Record has been deleted.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
				
				

    } else {
    	$msg = '<div class="alert alert-error"><strong>Error: </strong>Record could not be deleted.
        					<button type="button" class="close" data-dismiss="alert">×</button></div>';
	  echo mysqli_error($conn);
	}
}
// END OF DELETE RECORD
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

            	<div class="module module-login span4 offset1">
            		<form action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
								<h2>Client Info</h2>
						</div>
						<div class="module-body">
							<div class="media-avatar pull-left">
		                        <img src="images/user.png">
		                    </div>
							   <?php
								$cid=intval($_GET['cid']);
						        
						        $sql = "SELECT * from clients where `ID` = '$cid' ";
				                $result = $conn->query($sql);
				                  
				                   while($row = mysqli_fetch_assoc($result)) { 
				                        $Cfname =$row['FNAME'];
				                        $Clname =$row['LNAME'];
				                        $Cnumber =$row['PNUMBER'];
				                        $Cstatus= $row['STATUS'];
				                        $Cemail= $row['EMAIL'];
				                        $joined=$row['RegDATE'];
				                        $cid =$row['ID'];
				                    }
					           ?>             
						 	<div class="pull-right">
	                            <p class="profile-brief">
	                                <ul class="unstyled">
	                                    <li><strong>Name:</strong> <?php echo $Cfname.' '.$Clname; ?></li>
	                                    <li><strong>Mobile:</strong> <?php echo $Cnumber; ?></li>
	                                    <li><strong>Email:</strong> <?php echo $Cemail; ?></li>
	                                    <li><em>Registered:</em> <?php echo $joined; ?></li>
	                                    <li><em>Client Status:</em> 
	                                    	<?php 
	                                    	if($Cstatus == 1){echo ("Active");}
	                                    	if($Cstatus == 0){echo ("Blocked");}
	                                    	?>
	                                    </li>
	                                </ul>
	                            </p>
	                            <input name="status" type="submit" class="btn btn-link pull-right" value="
	                        	<?php 
	                        	if($Cstatus == 1){echo ("Block");}
	                        	if($Cstatus == 0){echo ("Activate");}
	                            ?>">
		                    </div>
	                	</div>
	                	<input name="state" type="number" value="<?php echo $Cstatus; ?>" class="hidden pull-left">
                	</form>
				</div>

				<div class="module module-login span3 offset">
					<div class="module-head">
                        <h3>Issue Book to Client</h3>
                    </div>
                    <div class="module-body">
                    	<form action="" class="form-vertical" method="post" enctype="multipart/form-data">
                    		<div class="control-group">
								<label class="control-label" for="basicinput">Select Book</label>
								<div class="controls">
									<select name="book" tabindex="1" data-placeholder="" class="span2">
										<option value=""></option>
										<?php 
										$cid=intval($_GET['cid']);
                                		$serial = 1;
								        $sql2 = 'SELECT * from books';
                                        $result = mysqli_query($conn, $sql2);
                                        if (mysqli_num_rows($result) > 0) {
                                        // output data of each row
                                        while($row = mysqli_fetch_assoc($result)) { 
										?>
										<option value="<?php echo $row['ID']?>" required><?php echo $row['BookName']?><br>
										<?php
 
                                        $serial++;
 
                                        }
										}
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<label for="name" class="col-form-label">Return Date</label>
									<input class="span2" name="returnDate" type="date" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="issue" class="btn btn-primary" value="Issue">
								</div>
							</div>
                		</form>
                    </div>
				</div>
				
			</div>


			<div class="row">
				<div class="module  span8 offset4">
					<div class="module-head">
                        <h3>Borrowed Books</h3>
                    </div>

                    <div class="module-body table">
                        <table cellpadding="0" cellspacing="0" border="0" id="dataTables-example" class="table table-bordered table-striped datatable"
                            width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">S/N</th>
                                    <th style="text-align: center;">Books</th>
                                    <th style="text-align: center;">Date Borrowed</th>
                                    <th style="text-align: center;">Due Date</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Return</th>
                            </thead>

                            <?php
                            	$cid=intval($_GET['cid']);
                                $serial = 1;
                                $sql = "SELECT issuedbooks.DateIssued, issuedbooks.DueDate, issuedbooks.ReturnStatus, issuedbooks.ID as ID, books.BookName  FROM ISSUEDBOOKS join BOOKS on books.ID = issuedbooks.BookID where `ClientID` = '$cid' 
                                	order by issuedbooks.ReturnStatus ";
                                $result = $conn->query($sql);

                                if (mysqli_num_rows($result)>0){

                                while($row = mysqli_fetch_assoc($result)) {
                                	 $retid =  $row['ID'];
                                	 $books =  $row['BookName'];
                                     $issued =  $row['DateIssued'];
                                     $due =  $row['DueDate'];
                                     $rstatus =  $row['ReturnStatus'];
                            ?>
                            <tbody>
                            	<form action="" method="post" enctype="multipart/form-data">
	                                <tr class="odd gradeX">
	                                    <td style="text-align: center;"><?php echo $serial; ?></td>
	                                    <td style="text-align: center;"><b><?php echo $books; ?></b></td>
	                                    <td style="text-align: center;"><?php echo $issued; ?></td>
	                                    <td style="text-align: center;"><?php echo $due; ?></td>
	                                    <td style="text-align: center;">
	                                    	<?php 
	                                    		if ($rstatus == 1){ echo ("Returned");} 
	                                    		else if ($rstatus == 0){ echo ("Not yet returned");} 
	                                    	?>
	                                	</td>
	                                	<td style="text-align: center;"><a href="" onclick="return confirm('Return this book?');"" ><button type="submit" name="return" class="btn btn-info" <?php if($rstatus ==1){ echo("disabled");}?> ><i class="icon-share"></i></button>
	                                		<a href="" onclick="return confirm('Delete this record?');"" ><button type="submit" name="del" class="btn btn-danger"><i class="icon-trash"></i></button></td>
                                		<input name="retid" type="number" value="<?php echo $retid; ?>" class="hidden span1">
	                                </tr>
	                            </form>
                            </tbody>
                            <?php $serial++;
                                } 
                            } else {
                            	echo ("$Cfname hasn't borrowed any book yet.");
                            }
                            ?>
                        </table>
                    </div>
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