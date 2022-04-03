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

// EDIT PROFILE
if(isset($_POST['update'])){  

$fullname = mysqli_escape_string($conn, $_POST['fullname']);
$username = mysqli_escape_string($conn, $_POST['username']);
$emailn = mysqli_escape_string($conn, $_POST['email']);
$pnumber = mysqli_escape_string($conn, $_POST['pnumber']);

$sql1 ="UPDATE admin SET `FULLNAME` = '$fullname', `USERNAME` = '$username', `EMAIL` = '$emailn', `PNUMBER` = '$pnumber', `LastUPDATED` = NOW() WHERE ID = '$id' ";
        if ($conn->query($sql1) === TRUE) {
   
    $msg = '<div class="alert alert-success dismissible"><strong>Your Profile has been updated.</strong></div>';
     
  } else {
 
 $msg = '<div class="alert alert-danger dismissible"><strong>Your profile could not be updated: '.mysqli_error($conn).'</strong></div>';
 
   }
}


// UPDATE PASSWORD
if(isset($_POST['updatePwd'])){  

//code for captcha verification
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
    echo "<script>alert('Incorrect verification code');</script>" ;
} 
else {

$password = mysqli_escape_string($conn, $_POST['password']);
$confirm = mysqli_escape_string($conn, $_POST['confirmPassword']);

if ($password != $confirm){
?>
    <script>
      alert("Password and Confirm Password Field do not match!!");
      window.location = "admin-profile.php";
    </script>
    <?php
} else {

$hash = password_hash($password, PASSWORD_BCRYPT);

$sql2 ="UPDATE admin SET `PASSWORD` = '$hash', `LastUPDATED` = NOW() WHERE ID = '$id' ";
        if ($conn->query($sql2) === TRUE) {

        $msg = '<div class="alert alert-success dismissible"><strong>Your Password has been updated</strong></div>'; 

    } else {

 echo mysqli_error($conn);
  }
}
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
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
        rel='stylesheet'>
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
                </div>
                <!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-body">
                                <div class="profile-head media">
                                    <a href="#" class="media-avatar pull-left">
                                        <img src="images/user.png">
                                    </a>
                                    <div class="media-body module-body">
                                        <?php
                                            $sql = "SELECT * from admin where ID = '$id' ";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                              
                                               while($row = mysqli_fetch_assoc($result)) { 
                                                    $_SESSION['fullname'] =$row['FULLNAME'];
                                                    $_SESSION['username'] =$row['USERNAME'];
                                                    $_SESSION['pnumber'] =$row['PNUMBER'];
                                                    $_SESSION['adminid']= $row['ID'];
                                                    $_SESSION['admin']= $row['EMAIL'];
                                                    $adminid=$row['ID'];

                                                    $id=$_SESSION['adminid'];
                                                    $fullname=$_SESSION['fullname'];
                                                    $username=$_SESSION['username'];
                                                    $email=$_SESSION['admin'];
                                                    $pnumber=$_SESSION['pnumber'];
                                                }

                                            }
                                        ?>
                                        <h4>
                                            <?php echo $fullname; ?> <small style="color:green;">ADMIN</small>
                                        </h4>
                                        <p class="profile-brief">
                                            <ul class="unstyled">
                                                <li><strong>Name:</strong> <?php echo $fullname; ?></li>
                                                <li><strong>Mobile:</strong> <?php echo $pnumber; ?></li>
                                                <li><strong>Email:</strong> <?php echo $email; ?></li>
                                            </ul>
                                        </p>
                                    </div><br>
                                    <div class="pull-left">
                                        <?php echo $msg; ?>
                                    </div>
                                </div>
                                <ul class="profile-tab nav nav-tabs">
                                    <li class="active"><a href="#edit" data-toggle="tab">Edit</a></li>
                                    <li><a href="#changePwd" data-toggle="tab">Change Password</a></li>
                                </ul>
                                <div class="profile-tab-content tab-content">

                                    <!-- EDIT PROFILE -->

                                    <div class="tab-pane fade active in" id="edit">
                                       <form name="editProfile" class="form-vertical" action="" method="post" enctype="multipart/form-data">

                                        <div class="module-body">
                                            <div class="control-group">
                                                <div class="controls row-fluid">
                                                    <label for="fname" class="col-form-label">Full Name</label>
                                                    <input class="span12" type="text" name="fullname" id="fullname" placeholder="" 
                                                     value="<?php echo $fullname; ?>" required>
                                                </div>
                                            </div>
                                        <div class="control-group">
                                            <div class="controls row-fluid">
                                                <label for="lname" class="col-form-label">User Name</label>
                                                <input class="span12" type="text" name="username" id="username" placeholder="" 
                                                value="<?php echo $username; ?>" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls row-fluid">
                                                <label for="lname" class="col-form-label">E-mail</label>
                                                <input class="span12" type="email" type="email" name="email" id="emailid" placeholder="" value="<?php echo $email; ?>" required >
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls row-fluid">
                                                <label for="lname" class="col-form-label">Phone Number</label>
                                                <input class="span12" type="number" name="pnumber" id="pnumber" maxlength="14" placeholder="" value="<?php echo $pnumber; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="module-foot">
                                        <div class="control-group">
                                            <div class="controls clearfix">
                                                <input type="submit" name="update" id="#update_button" class="btn btn-primary pull-right" value="Update">
                                            </div>
                                        </div>
                                    </div>
                    </form>
                    </div>
                    <!--/ EDIT PROFILE-->


                                <!-- CHANGE PASSWORD --> 
                                <div class="tab-pane fade" id="changePwd">
                                    <form name="changePwd" class="form-vertical" action="" method="post"  enctype="multipart/form-data">
                                        <div class="module-body">
                                            <div class="control-group">
                                                <div class="controls row-fluid">
                                                    <label for="inputPassword" class="col-form-label">Password</label>
                                                    <input class="span12" name="password" type="password" id="inputPassword" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls row-fluid">
                                                    <label for="inputPassword" class="col-form-label">Confirm Password</label>
                                                    <input class="span12" name="confirmPassword"  type="password" id="confirmPassword" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label>Verification code</label><img src="captcha.php">
                                                <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 15px;" />
                                            </div>      
                                        </div>
                                        <div class="module-foot">
                                            <div class="control-group">
                                                <div class="controls clearfix">
                                                    <input type="submit" name="updatePwd" id="#update_pwd" class="btn btn-primary pull-right" value="Update">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--/ CHANGE PASSWORD --> 

                            </div>
                            <!--/.module-body-->
                        </div>
                        <!--/.module-->
                    </div>
                    <!--/.content-->
                </div>
                <!--/.span9-->
            </div>
        </div>
        <!--/.container-->
    </div>
    <!--/.wrapper-->
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
