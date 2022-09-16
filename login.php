<?php
session_start();
error_reporting(0);
include ("connect.php");

//clear session if user is already logged in
if($_SESSION['email']!=''){
$_SESSION['email']='';
}

if(isset($_POST['login'])){	

//code for captcha verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
    echo "<script>alert('Incorrect verification code');</script>" ;
} 
else {
	
$email = mysqli_escape_string($conn, $_POST['email']);
$password = mysqli_escape_string($conn, $_POST['password']);


$sql = "SELECT * from clients where EMAIL = '$email' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
   while($row = mysqli_fetch_assoc($result)) {
   	if (password_verify($password, $row['PASSWORD'])){	
	    $_SESSION['fname'] =$row['FNAME'];
	    $_SESSION['lname'] =$row['LNAME'];
      	$_SESSION['pnumber'] =$row['PNUMBER'];
		$_SESSION['userid']= $row['ID'];
		$_SESSION['email']= $row['EMAIL'];
		$userid=$row['ID'];
		

// if remember me clicked, store value in Cookies for 7 days
  if (!empty ($_POST['remember'])) {
	  //cookies for username
	  setcookie("user", $_POST['email'], time()+ (7 * 24 * 60 * 60));
	  //cookies for password
	  setcookie("userpassword", $_POST['password'], time()+ (7 * 24 * 60 * 60));

  }else {
	  if (isset ($_COOKIE["user"])) {
		  setcookie ("user", " ");
		  if (isset ($_COOKIE["userpassword"])) {
		  setcookie ("userpassword", " ");
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


// REGISTER
if(isset($_POST['register'])){	

//code for captcha verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
    echo "<script>alert('Incorrect verification code');</script>" ;
} 
else {
	
$fname = mysqli_escape_string($conn, $_POST['fname']);
$lname = mysqli_escape_string($conn, $_POST['lname']);
$email = mysqli_escape_string($conn, $_POST['email']);
$pnumber = mysqli_escape_string($conn, $_POST['pnumber']);
$password = mysqli_escape_string($conn, $_POST['password']);

$hash = password_hash($password, PASSWORD_BCRYPT);

$sql1 ="SELECT EMAIL FROM clients WHERE EMAIL = '$email' ";
        $result = $conn->query($sql1);

        if ($result->num_rows > 0) {
          echo "<script>alert('Email already in use');</script>" ;
        }

else {        

$sql = "INSERT INTO clients (`FNAME`,`LNAME`,`EMAIL`,`PNUMBER`,`PASSWORD`, `RegDATE`) 
		VALUES ('$fname', '$lname', '$email', '$pnumber', '$hash', NOW() );"; 

if ($conn->query($sql) === TRUE) {
	?>
	<script>
	  alert("Cheers! You've been successfully registered to our Library Service");
	  window.location = "index.php";
	</script>
	<?php
              die();	  
		 
  } else {

 echo mysqli_error($conn);
  }
}
}
}

//FORGOT PASSWORD
if(isset($_POST['forgot_password'])){	

	
$name = mysqli_escape_string($conn, $_POST['name']);
$email = mysqli_escape_string($conn, $_POST['email']);
$number = mysqli_escape_string($conn, $_POST['pnumber']);
$address = mysqli_escape_string($conn, $_POST['address']);

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

<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").php(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<script type="text/javascript">
function valid()
{
if(document.signUP.password.value!= document.signUP.confirmPassword.value)
{
alert("Password and Confirm Password Field do not match!!");
document.signUP.confirmPassword.focus();
return false;
}
return true;
}
</script>    
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
                        <li><a href="#register" data-toggle="tab">Sign Up</a></li>
                        <li><a href="#forgot_password" data-toggle="tab">Forgot Password</a></li>
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
							<h3>Login</h3>
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
                                <label>Verification code</label><img src="./captcha.php">
                                <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 15px;" />&nbsp;
                            </div>        
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="login" class="btn btn-primary pull-right" value="Login">
									<label class="checkbox">
										<input name="remember" type="checkbox"> Remember me
									</label>
								</div>
							</div>
						</div>
					</form>
				   </div>
			      

                   <!--REGISTER TAB-->
                   <div class="tab-pane fade in" id="register">
                    <form name="signUP" class="form-vertical" action="" method="post" enctype="multipart/form-data" onSubmit="return valid();">
						<div class="module-head">
							<h3>Register</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="fname" class="col-form-label">First Name</label>
									<input class="span12" type="text" name="fname" id="fname" placeholder="" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="lname" class="col-form-label">Last Name</label>
									<input class="span12" type="text" name="lname" id="lname" placeholder="" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="lname" class="col-form-label">E-mail</label>
									<input class="span12" type="email" name="email" id="emailid" onBlur="checkAvailability()" placeholder="" required>
									<span id="user-availability-status" style="font-size:12px;"></span>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="lname" class="col-form-label">Phone Number</label>
									<input class="span12" type="number" name="pnumber" id="pnumber" maxlength="14" placeholder="" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="inputPassword" class="col-form-label">Password</label>
									<input class="span12" name="password" type="password" id="inputPassword" placeholder="" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="inputPassword" class="col-form-label">Confirm Password</label>
									<input class="span12" name="confirmPassword" type="password" id="confirmPassword" placeholder="" required>
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
									<input type="submit" name="register" id="#register_button" class="btn btn-primary pull-right" value="Register">
								</div>
							</div>
						</div>
					</form>
				  </div>


                  <!--FORGOT PASSWORD TAB-->
				  <div class="tab-pane fade in" id="forgot_password">
                    <form class="form-vertical" action="" method="post" enctype="multipart/form-data">
						<div class="module-head">
							<h3>Forgot Password</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<label for="inputEmail" class="col-form-label">Input your E-mail</label>
									<input class="span12" type="email" id="inputEmail" placeholder="" required>
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<input type="submit" name="forgot_password" class="btn btn-primary pull-right" value="Send Reset link">
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