<?php 
include ("connect.php");
// code user email availablity
if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "<span style='color:red'>Error: You did not enter a valid Email.</span>";
		echo "<script>$('#register_button').prop('disabled',true);</script>";
	}
	else {

		$sql ="SELECT EMAIL FROM clients WHERE EMAIL = '$email' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
 echo "<span style='color:red'> Email already in use.</span>";
 echo "<script>$('#register_button').prop('disabled',true);</script>";
} 

else{
echo "<span style='color:green'> Email available for Registration.</span>";
echo "<script>$('#register_button').prop('disabled',false);</script>";
}

}
}


?>