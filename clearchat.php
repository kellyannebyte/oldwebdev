<?php
	include("config.php");
	$room = $_POST['clear_room'];

	$file = $path."/".$room;

	file_put_contents($file, "");
	header("Location: admin.php");
	exit();

?>