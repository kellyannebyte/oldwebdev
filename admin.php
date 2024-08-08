<?php
	include("config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chatroom</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<style type="text/css">
		body{
			background-image: url("images/exit.jpg");
		}
	</style>
</head>
<body>
	<h1 style="color: white">Admin Login</h1>
	<a href="index.php"><button id="back_button">Back</button></a>
	<div id="admin_panel">
            <?php
            	if($_COOKIE['adminlogin'] || $_GET['login']){
            		?>
					<div id="admin_menu">
						<form id="clear_chat" method="POST" action="clearchat.php">
							<span style="color: teal;">Clear a Chatroom?</span>
							<select name="clear_room">
								<option value="room1.txt">Wind Waker</option>
								<option value="room2.txt">Ocarina of Time</option>
								<option value="room3.txt">Twilight Princess</option>
								<option value="room4.txt">Breath of the Wild</option>
							</select>
							<input type="submit" value="clear">
						</form><br>
						<form>
							<br>
							<span style="color: teal;">Usage Logs:</span>
							<div style="text-align: center; margin-left: 45px">
								<table cellspacing="10px;" style="font-size: 10px;">
									<tr>
						              <th style="padding-right: 25px;padding-left: 10px">IP address</th>
						              <th style="padding-right: 20px">Time stamp</th>
						              <th style="padding-right: 5px">Username</th>
						              <th>Identity</th>
						              <th>Action</th>
						            </tr>
								</table>
							</div>
							<div id="logs">
								<?php
						          $history = file_get_contents($path."/logs.txt");
						          $history = trim($history);
						          $split_history = explode("\n",$history);
						          foreach ($split_history as $key => $value) {
						            $split_history[$key] = explode("|", $split_history[$key]);
						          }
						          ?>
						          <table cellspacing="15px;">
						            
						          <?php
						            foreach ($split_history as $key => $value) {
						              print("<tr><td>".$split_history[$key][0]."</td><td>".date('Y-m-d H:i:s', $split_history[$key][1])."</td><td>".$split_history[$key][2]."</td><td>".$split_history[$key][3]."</td><td>".$split_history[$key][4]."</td></tr>");
						            }
						          ?>
						          </table>
						          <?php
						        ?>
							</div>
						</form>
						<form method="POST" action="logout.php" style="text-align: center;">
							<br><input type="submit" value="log out">
						</form>
					</div>
            		<?php
            	}else{
            		?>
            		<form id="admin_login_panel" method="POST" action="login.php">
						Username: <input type="text" name="admin_username"><br><br>
            			Password: <input type="text" name="admin_password" style="margin-left: 6px"><br><br>
            			<input type="submit" value="Log in">
            		</form>
            		<?php
            	}
            	if ($_GET['loginerror']){
            		?>
            		<br><strong style="color: red">Log in Failed!</strong>
            		<?php
            	}
            ?>
		
	</div>

</body>
</html>