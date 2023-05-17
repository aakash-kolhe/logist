<?php
	 $hostName = "localhost";
	 $userName = "root";
	 $dbpass = "";
	 $dbName = "infimetrics_transmetrics";

	 $conn = mysqli_connect($hostName, $userName, $dbpass, $dbName);
	 if(!$conn){
		die("connection_failed:" .mysql_connect_error());
	 }
?>
