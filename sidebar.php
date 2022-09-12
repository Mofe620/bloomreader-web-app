<?php
$userid = $_SESSION['userid'];
$sql = "SELECT COUNT(`ID`) FROM admin_resp WHERE `ClientID` = $userid";
$result = $conn->query($sql);
while($row = mysqli_fetch_assoc($result)) {
	$admin_resp = $row['COUNT(`ID`)'];
}
?>
<div class="sidebar">
    <ul class="widget widget-menu unstyled">
        <li class="active"><a href="index.php"><i class="menu-icon icon-home"></i>Dashboard
            </a></li>
        <li><a href="books.php"><i class="menu-icon icon-book"></i>Books </a>
        </li>
        <li><a href="message.php"><i class="menu-icon icon-envelope"></i>Messages<b class="label green pull-right">
                    <?php echo $admin_resp; ?></b> </a></li>
        <li><a href="profile.php"><i class="menu-icon icon-user"></i>Profile </a></li>
        <li><a href="logout.php"><i class="menu-icon icon-signout"></i>Logout </a></li>
    </ul>
    <!--/.widget-nav-->
</div>