<?php
	include("config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chatroom</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1 style="color: white;">Welcome to the Chatroom. Let's Chat!</h1>
	<div id="start_panel">
		<a href="admin.php"><button id="admin_login_button">Admin Login</button></a>
		Nickname:
		<input type="text" id="nickname"><br>
		Select A Chatroom:
		<select id="select_room">
<!-- 			<option value="defult">select a chatroom</option>
 -->		<option value="room1.txt">Wind Waker</option>
			<option value="room2.txt">Ocarina of Time</option>
			<option value="room3.txt">Twilight Princess</option>
			<option value="room4.txt">Breath of the Wild</option>
		</select>
		<br><br>
		<button id="start">Start Chatting!</button><br><br>
		<div id="alert_box" class="hidden"></div>
	</div>
	<div id="chat_panel" class="hidden">
		<form method="POST" action="logout.php"><input type="submit" id="user_exit_button" value="Exit Chat"></form>
		<textarea id="chat_history" readonly onload="scrollTo(0,document.getElementById('chat_history').scrollHeight)"></textarea><br>
		<button id="change_username">Change Username?</button>
		<div id="display_username" style="color: white"></div>
		<input type="text" id="message">
		<button id="send_message">Send</button><br>
	</div>

	



	<!-- bring in the jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script type="text/javascript">

    	$(document).ready(function(){
    		let startPenel = document.getElementById('start_panel');
    		let nickname = document.getElementById('nickname');
    		let start = document.getElementById('start');
    		let chatPanel = document.getElementById('chat_panel');
    		let message = document.getElementById('message');
    		let sendBtn = document.getElementById('send_message');
    		let chatHistory = document.getElementById('chat_history');
    		let changeUsernameBtn = document.getElementById('change_username');
    		let selectRoom = document.getElementById('select_room');
            let userExitBtn = document.getElementById('user_exit_button');

    		let username = '';
            let thisRoom = '';
			//if reenter the page and there is a cookie "username"
    		//username will be fetched from the cookie
    		//and hide the start panel

    		//ajax call to validate if there is a cookie called 
    		$.ajax({
    			url:'cookiecall.php',
    			type: 'POST',
    			data:{},
    			success: function(data,status){
    				if (data != '') {
    					username = data;
    					startPenel.classList.add('hidden');
    					chatPanel.classList.remove('hidden');
                        document.querySelector('body').style.backgroundImage = "url('images/exit.jpg')";
                        document.querySelector('h1').style.color = "white";
    					document.getElementById('display_username').innerHTML = username+":";
    				}
    			}
    		})

            //ajax call to validate the chatroom that it had been before
            $.ajax({
                url:'validatechat.php',
                type: 'POST',
                data:{},
                success: function(data,status){
                    if (data != '') {
                        thisRoom = data;
                        //already logged in, load the chat based on cookie
                        getChatMessagesFirstTime();
                        getChatMessages();
                    }else{
                        thisRoom = selectRoom.value;
                    }
                    
                }
            })
    		

    		//create a room
    		//when clicking the button, an promptbox should appear, just like below the change name
    		//it would require a user input for the chatroom's name

    		//when they click the start chatting button
    		//we need to show the other panel
    		start.onclick = function(){
    			//send the username to an php file for validation 
    			username = nickname.value;
                thisRoom = selectRoom.value;
    			$.ajax({
    				url:'nickname.php',
    				type: 'POST',
    				data:{
    					name: username,
                        room: thisRoom,
    					action: "0"
    				},
    				success: function(data,status){
    					
    					if (data == "error=0" || data == "error=1") {
    						//empty username or empty after removing all invalid chars
    						document.getElementById('alert_box').innerHTML = "Invalid Username!";
    						document.getElementById('alert_box').classList.remove('hidden');
    					}else{
    						//changed username from invalid input or totally valid username
    						username = data;
    						startPenel.classList.add('hidden');
    						chatPanel.classList.remove('hidden');
    						document.getElementById('display_username').innerHTML = username+":";
                            document.querySelector('body').style.backgroundImage = "url('images/exit.jpg')";
                            document.querySelector('h1').style.color = "white";
                            //fresh start ok, load the chats 
                            getChatMessagesFirstTime();
                            getChatMessages();
    					}
    					
    				}

    			})
    		}

    		//scroll to the bottom of the textarea (chat history) automatically when enter the page
    		function scrollToBottom(){
	    		var text = document.getElementById('chat_history');
	    		text.scrollTop = text.scrollHeight;
	    	}
           

    		//set up the send message button to send message to the server
    		sendBtn.onclick = function(event){
    			let msg = message.value;
    			//contact the server with an ajax call
    			$.ajax({
    				url:'save.php',
    				type: 'POST',
    				data:{
    					name: username,
    					message: msg,
    					room: thisRoom
    				},
    				success: function(data,status){
    					if(data == "success"){
    						scrollToBottom();
    						//clear what is in the input text box
    						message.value = '';
    					}
    					
    				}

    			})
    		}


    		function getChatMessagesFirstTime(){
    			// let thisRoom = selectRoom.value;

    			$.ajax({
    				url:'data/'+thisRoom+'?nochache='+Math.random(),
    				type:'GET',
    				data:{},
    				success: function(data,status){
    					chatHistory.value = data;
    					//when the user enter the chatroom, scoll the history to the newest/bottom
    					scrollToBottom();
                        
    				}
    			})
    		}

    		function getChatMessages(){
                // let thisRoom = selectRoom.value;
    			$.ajax({
    				url:'data/'+thisRoom+'?nochache='+Math.random(),
    				type:'GET',
    				data:{},
    				success: function(data,status){
    					chatHistory.value = data;
    					//in about 2 senconds, do this again
    					setTimeout(getChatMessages, 1000);
    				}
    			})
    		}


    		changeUsernameBtn.onclick = function(event){
    			let changedName = prompt("Please Enter a new name:");
    			if(changedName === null){
    				return;
    			}
    			if(changedName == ""){
    				alert('username cannot be blank!');
    			}else{
    				console.log(changedName);
    				$.ajax({
    					url:'nickname.php',
    					type: 'POST',
	    				data:{
	    					name: changedName,
	    					oldname: username,
	    					action: "1"
	    				},
	    				success: function(data,status){
	    					if (data == "error=1") {
	    						//empty after removing all invalid chars
	    						alert('username must be alphanumeric!');
	    					}else{
	    						//changed username from invalid input or totally valid username
	    						username = data;
	    						//set localstorage
	    						//localStorage.setItem("username",data);
	    						document.getElementById('display_username').innerHTML = username+":";
	    						alert("You have changed your username to: " + data+"\n(after exluding all invalid characters)");
	    						//re-enter the page so the localstorage is set
	    						// window.location.reload(true);
	    					}
	    				}
    				})
    			}
    		}

            userExitBtn.onclick = function(event){
                document.querySelector('body').style.backgroundImage = "url('images/mable.jpg')";
                document.querySelector('h1').style.color = "black";
            }


    	})
    </script>


</body>
</html>