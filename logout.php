<?php
	include("config.php");
	$id = $_COOKIE['identity'];
	$time = time();
	$track = $_SERVER['REMOTE_ADDR']."|".$time."|".$_COOKIE['username']."|".$_COOKIE['identity']."|log out\n";
	file_put_contents($path."/logs.txt",$track,FILE_APPEND);

	//destroy all cookies
	setcookie("username","",time()-3600);
	if($_COOKIE['adminlogin']){
		setcookie("adminlogin","",time()-3600);
	}
	if ($_COOKIE['chatroom']) {
		setcookie("chatroom","",time()-3600);
	}
	setcookie("identity","",time()-3600);

	//send back to admin or index?
	if ($_COOKIE['identity']=="admin"){
		header("Location: admin.php");
		exit();
	}elseif ($_COOKIE['identity']=="user") {
		header("Location: index.php");
		exit();
	}
	
?>