<?php
	//grab the username and password
	$username = $_POST['admin_username'];
	$password = $_POST['admin_password'];

    //check if the username and password match
    //if match, set a cookie called adminlogin
    //and direct back to the admin.php
    //if not match, direct back to the admin.php with a loginerror=true
    $user = 'pikachu';
    $pass = 'pokemon';

    if ($username == $user && $password == $pass) {
        setcookie("adminlogin","yes");
        setcookie("username",$username);
        setcookie("identity","admin");

        $time = time();
        $track = $_SERVER['REMOTE_ADDR']."|".$time."|".$username."|admin|log in\n";
        file_put_contents($path."/logs.txt",$track,FILE_APPEND);

        //direct back to the admin.php
        header("Location: admin.php?login=success");
        
        exit();
    }else{
        //login failed
        header("Location: admin.php?loginerror=true");
        exit();
    }

?>