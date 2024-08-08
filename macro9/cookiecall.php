<?php
	//if there is a cookie, it means that the user logged in before 
	//send the data back to tell index.php to remove the login_panel and display the chat_panel
	if($_COOKIE['username'] && $_COOKIE['identity']=="user"){
		print($_COOKIE['username']);
		exit();
	}
	print('');
	exit();

?>
