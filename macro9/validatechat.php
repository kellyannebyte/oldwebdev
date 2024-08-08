<?php
	//if there is a cookie, it means that the user logged in before 
	//send the data back to tell index.php to display certain chatroom
	if($_COOKIE['chatroom']){
		print($_COOKIE['chatroom']);
		exit();
	}
	print('');
	exit();

?>
