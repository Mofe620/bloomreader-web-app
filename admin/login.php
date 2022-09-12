<?php
session_start();
error_reporting(0);
include ("connect.php");

//clear session if admin is already logged in
if($_SESSION['admin']!=''){
$_SESSION['admin']='';
}

if(isset($_POST['login'])){	

//code for captcha verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
    echo "<script>alert('Incorrect verification code');</script>" ;
} 
else {
	
$email = mysqli_escape_string($conn, $_POST['email']);
$password = mysqli_escape_string($conn, $_POST['password']);


$sql = "SELECT * from admin where EMAIL = '$email' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
   while($row = mysqli_fetch_assoc($result)) {
   	if (password_verify($password, $row['PASSWORD'])){	
	    $_SESSION['fullname'] =$row['FULLNAME'];
	    $_SESSION['username'] =$row['USERNAME'];
      	$_SESSION['pnumber'] =$row['PNUMBER'];
		$_SESSION['adminid']= $row['ID'];
		$_SESSION['admin']= $row['EMAIL'];
		$adminid=$row['ID'];
		

// if remember me clicked, store value in Cookies for 7 days
  if (!empty ($_POST['remember'])) {
	  //cookies for username
	  setcookie("admin", $_POST['email'], time()+ (7 * 24 * 60 * 60));
	  //cookies for password
	  setcookie("adminpassword", $_POST['password'], time()+ (7 * 24 * 60 * 60));

  }else {
	  if (isset ($_COOKIE["admin"])) {
		  setcookie ("admin", " ");
		  if (isset ($_COOKIE["adminpassword"])) {
		  setcookie ("adminpassword", " ");
		  }
	  }
}
//Redirect
		header ("location: index.php");
        die();
			  
			 
   } else { echo "<script>alert('Incorrect Password');</script>" ;} 
 }  
}   else { echo "<script>alert('E-mail address not found');</script>" ;}
}
}

?>

<!DOCTYPE html>
<html lang="en">
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

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="index.php">
			  		BloomReader Library
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
					<ul class="nav nav-tabs pull-right">
                        <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
					</ul>

				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
				  <div class="tab-content">

				   <!--LOGIN TAB-->
                   <div class="tab-pane fade active in" id="login">
					<form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Admin Login</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="inputEmail" class="col-form-label">E-mail</label>
									<input class="span12" name="email" type="email" id="inputEmail" placeholder="" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="inputPassword" class="col-form-label">Password</label>
									<input class="span12" name="password" type="password" id="inputPassword" placeholder="" required>
								</div>
							</div>
							<div class="control-group">
                                <label>Verification code</label><img src="captcha.php">
                                <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 15px;" />&nbsp;
                            </div>        
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="login" class="btn btn-primary pull-right" value="Login">
							<!--	<label class="checkbox">
										<input name="remember" type="checkbox"> Remember me
									</label> -->
								</div>
							</div>
						</div>
					</form>
				   </div>
			                        
				 </div>
				</div>
			</div>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		
	</div>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>