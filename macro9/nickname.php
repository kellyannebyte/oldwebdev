<?php
	include('config.php');

	$name = $_POST['name'];
	$action = $_POST['action'];
	$room = $_POST['room'];
	

	if ($name == "") {
		print('error=0');
		exit();
	}
	if(!ctype_alnum($name)){
		$newname = '';
		$split_name = str_split($name);
		foreach ($split_name as $char) {
			if(ctype_alnum($char)){
				$newname = $newname.$char;
			}
		}
		// if after removing all invalid char, the name is still empty:
		if($newname == ''){
			print('error=1');
		}else{
			//valid case
			//write the action log
			$time = time();
			if ($action == "0") {
				//enter room, new name, login 
				$track = $_SERVER['REMOTE_ADDR']."|".$time."|".$newname."|user|log in\n";
				file_put_contents($path."/logs.txt",$track,FILE_APPEND);

			}else{
				//change name
				//get old name
				$oldname = $_POST['oldname'];
				//track 1
				$track1 = $_SERVER['REMOTE_ADDR']."|".$time."|".$oldname."|user|edit name\n";
				file_put_contents($path."/logs.txt",$track1,FILE_APPEND);
				//track 2
				$track2 = $_SERVER['REMOTE_ADDR']."|".$time."|".$newname."|user|new name\n";
				file_put_contents($path."/logs.txt",$track2,FILE_APPEND);

			}
			//set cookie
			setcookie("username",$newname);
			setcookie("identity","user");
			setcookie("chatroom",$room);
			//new username not empty after removing all invalid chars
			print($newname);
			
		}
		exit();
	}else{
		//valid case
		$time = time();
		if ($action == "0") {
			//enter room, new name, login 
			$track = $_SERVER['REMOTE_ADDR']."|".$time."|".$name."|user|log in\n";
			file_put_contents($path."/logs.txt",$track,FILE_APPEND);

		}else{
			//get old name
			$oldname = $_POST['oldname'];
			//track 1
			$track1 = $_SERVER['REMOTE_ADDR']."|".$time."|".$oldname."|user|edit name\n";
			file_put_contents($path."/logs.txt",$track1,FILE_APPEND);
			//track 2
			$track2 = $_SERVER['REMOTE_ADDR']."|".$time."|".$name."|user|new name\n";
			file_put_contents($path."/logs.txt",$track2,FILE_APPEND);
		}
		//set cookie
		setcookie("username",$name);
		setcookie("identity","user");
		setcookie("chatroom",$room);
		//valid user name: alphanumeric
		print($name);
		// header("Location: index.php");
		exit();
	}

?>
