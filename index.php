<?php
session_start();
include ("connect.php");

//restrict access to only logged in users
if(strlen($_SESSION['userid'])==0){ 
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
        <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    <style>
        .module-body.table {
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
                    </div>
                    <!--/.span3-->
                    <div class="span9">
                        <div class="content">
                            <?php
                                $sql = "SELECT * FROM ISSUEDBOOKS WHERE `ClientID` = '$id' ";
                                            if ($result = mysqli_query ($conn, $sql)){
                                               $issuedcount = mysqli_num_rows ($result);
                                            }

                                $sql1 = "SELECT * FROM ISSUEDBOOKS WHERE `ClientID` = '$id' AND `ReturnStatus` = '0' ";
                                            if ($result = mysqli_query ($conn, $sql1)){
                                               $notReturned = mysqli_num_rows ($result);
                                            }

                            ?>
                            <div class="btn-controls">
                                <div class="btn-box-row row-fluid">
                                    <a href="#" class="btn-box big span4"><i class=" icon-briefcase"></i><b><?php echo $issuedcount; ?></b>
                                       <p class="text-muted">
                                            Books Borrowed</p> 
                                    </a><a href="#" class="btn-box big span4"><i class="icon-book"></i><b><?php echo $notReturned; ?></b>
                                        <p class="text-muted">
                                            Books not Returned</p>
                                    </a><a href="#" class="btn-box big span4"><i class="icon-money"></i><b>15</b>
                                        <p class="text-muted">
                                            Total Credits</p>
                                    </a>
                                </div>
                                
                            </div>
                            <!--/#btn-controls-->
                            
                            <div class="alert">
                                <?php
                                    $sql = "SELECT * from announcements order by `ID` desc";
                                    $result = $conn->query($sql);
                                        while ($row = mysqli_fetch_assoc($result)){
                                            $subject = $row['SUBJECT'];
                                            $content = $row['CONTENT'];
                                            $date = $row['DATE'];
                                                if (mysqli_num_rows($result)>0){
                                                echo "<h5>Announcements:</h5><br>$subject<br>$content";
                                            }
                                        }
                                ?>
                            </div>

                            <div class="module">
                                <?php
                                    $serial = 1;
                                    $sql = "SELECT books.BookName, books.ISBN, issuedbooks.DateIssued, issuedbooks.DueDate, issuedbooks.ReturnStatus FROM ISSUEDBOOKS join CLIENTS on issuedbooks.ClientID = clients.ID join BOOKS on issuedbooks.BookID = books.ID WHERE clients.ID = '$id' 
                                        order by issuedbooks.ID ";
                                    $result = $conn->query($sql);
                                    $count = mysqli_num_rows($result);
                                ?>
                                <div class="module-head">
                                    <h3>Borrowed Books {<?php echo $count ?>}</h3>
                                </div>
                                <div class="module-body table">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">S/N</th>
                                                <th style="text-align: center;">Book Name</th>
                                                <th style="text-align: center;">ISBN</th>
                                                <th style="text-align: center;">Date Borrowed</th>
                                                <th style="text-align: center;">Due Date</th>
                                                <th style="text-align: center;">Return Status</th>
                                            </tr>
                                        </thead>

                                        <?php
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $book =  $row['BookName'];
                                                $isbn =  $row['ISBN'];
                                                $date =  $row['DateIssued'];
                                                $due =  $row['DueDate'];
                                                $status = $row['ReturnStatus'];
                                        ?>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td style="text-align: center;"><?php echo $serial; ?></td>
                                                <td style="text-align: center;"><?php echo $book; ?></td>
                                                <td style="text-align: center;"><?php echo $isbn; ?></td>
                                                <td style="text-align: center;"><?php echo $date; ?></td>
                                                <td style="text-align: center;"><?php echo $due; ?></td>
                                                <td style="text-align: center;"><?php
                                                 if ($status == 0){echo ("Not yet returned");} 
                                                 if ($status == 1){echo ("Returned");} 
                                                 ?></td>
                                            </tr>
                                        </tbody>
                                        <?php $serial++;
                                            }?>
                                    </table>
                                </div>
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
            
        </div>
        <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
        <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="scripts/common.js" type="text/javascript"></script>
      
    </body>
