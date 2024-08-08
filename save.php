<?php
	//define a path to folder
	include('config.php');

	//receive a message from the client 
	$name = $_POST['name'];
	$message = $_POST['message'];
	$room = $_POST['room'];

	//store a message in the data file
	$file_name = $path."/".$room;
	file_put_contents($file_name, $name.": ".$message."\n",FILE_APPEND);

	//tell the client that we are done  
	print("success");
	exit();

?>