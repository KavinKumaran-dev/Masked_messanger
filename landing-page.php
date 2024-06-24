<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing-Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
        html, body {
        height: 100%;
        margin: 0;
        position: relative;
        overflow:hidden;
    }
    .container {
        position: absolute;
        bottom: 45px;
        left: 65%;
        transform: translateX(-50%);
    }
        .in{
            width: 700px;
            height:45px;
            position: relative;
        }
        .container1 {
        position: relative;
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .image {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 20px;
        object-fit: cover;
        object-position: center;
    }
    .content {
        display: flex;
        align-items: center;
    }
    .text {
        flex-grow: 1;
    }
    .button {
        position: absolute;
        top: 22px;
        right: 70px;
    }
    #id{
        opacity:0;
    }
    #logout{
        text-decoration:none;
    }
    #logout:hover{
        color:red;
    }
    #message {
    width: 500px;
    height: 440px;
    overflow-y: auto; /* Enable vertical scrollbar only */
    border: 1px solid #ccc;
    padding: 10px;
    margin: 0 auto;
}

/* Style for WebKit browsers (e.g., Chrome, Safari) */
#message::-webkit-scrollbar {
    width: 7px; /* Width of the scrollbar */
}

#message::-webkit-scrollbar-thumb {
    background-color: rgba(200, 220, 255, 0.5); /* Color of the scrollbar thumb */
    border-radius: 10px; /* Rounded corners */
}

#message::-webkit-scrollbar-track {
    background-color: transparent; /* Transparent scrollbar track */
}
    @media (max-width:1000px) {
        .in {
            width: 500px;
        }
    }
        </style>
</head>
<body>
    <?php
    $name = "";
    $email = "";
    session_start();
    if(isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['id']) && isset($_SESSION['users'])) {
         $name = $_SESSION["username"];
         $email = $_SESSION["user_id"];
         $id =  $_SESSION['id'];
         $users = $_SESSION['users'];
    }
    ?>
    <div class="container1">
    <div class="content">
    <img src="image.jpg"  class="image" alt="Cinque Terre" width="304" height="236">
        <div class="text">
        <h5 id="name"><span><?php echo $name;?> </span></h5>
        <h6><span><?php echo $email;?></span><span id="id"><?php echo $id;?></span></h6>
        </div>
        <a id = "logout" class="button" href="signin.php">Logout?</a>
    </div>
</div>
<div>
    <label>Choose User:</label>
    <?php
        echo "<select id='dropdown' onchange='handleOptionChange()'>";
        echo "<option disabled selected>Choose User</option>";
        foreach($users as $user_name => $user_id){
            if($id != $user_id){
            echo "<option value = '$user_id'>$user_name</option>";
            }
        }
        echo "</select>";
    ?>
</div>
    <div id="message"></div>
    <div class="container">
        <div class="input-container">
    <input type="text" id="text-content" class="in" placeholder="Message...">
    <button type="button" id = "btn"class="btn btn-primary">Enter</button>        </div>
    </div>
</body>
<script>
    const inputField = document.getElementById("text-content");
    const button = document.getElementById("btn");
    let toId = 0;
        window.onload = function() {
        let storedToId = localStorage.getItem("selectedUser");
        if (storedToId) {
            let dropdown = document.getElementById("dropdown");
            dropdown.value = storedToId;
            toId = storedToId;
        }
       }
    function handleOptionChange(){
    let dropdown = document.getElementById("dropdown");
    let selectedOption = dropdown.options[dropdown.selectedIndex];
     toId = selectedOption.value;
     localStorage.setItem("selectedUser", toId);
    }
    window.onload = function() {
    let storedMessage = localStorage.getItem("storedMessage");
    if (storedMessage) {
        document.getElementById("message").innerHTML = storedMessage;
    }
    }
     button.addEventListener('click',function() {
        let str = inputField.value;
        // morse code convert 
        // let morseCode  = Morse.encode(str);
        // console.log(morseCode);
        const mapping = {
					"A" : ".-", "B" : "-...","C" : "-.-.", "D" : "-..",
					"E" : ".", "F" : "..-.", "G" : "--.", "H" : "....",
					"I" : "..", "J" : ".---", "K" : "-.-", "L" : ".-..",
					"M" : "--", "N" : "-.", "O" : "---", "P" : ".--.",
					"Q" : "--.-", "R" : ".-.", "S" : "...", "T" : "-",
					"U" : "..-", "V" : "...-", "W" : ".--", "X" : "-..-",
					"Y" : "-.--", "Z" : "--..",
					
					
					"0" : "-----",
					"1" : ".----", "2" : "..---", "3" : "...--",
					"4" : "....-", "5" : ".....", "6" : "-....",
					"7" : "--...", "8" : "---..", "9" : "----."
				}
        str = str.toUpperCase();

        let arr1 = str.split("");
        
        let arr2 = arr1.map(x => {
            if(mapping[x])
            {
                return mapping[x];
            }
            else{						
                return x;
            }
        });
	    let code = arr2.join(" ");
        str = code;
        console.log(code);
        let xhr = new XMLHttpRequest();
        let timestamp = Date.now();
        let name = document.getElementById("name");
        let id = document.getElementById("id").textContent;
        console.log(id);
        xhr.onreadystatechange = function(){
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    document.getElementById("message").innerHTML = this.responseText;
                    localStorage.setItem("storedMessage", this.responseText);
                }
                else {
                        console.error("Error:", xhr.status);
                    }
            }
        }
        xhr.open("GET","server.php?msg=" + encodeURIComponent(str) + "&time=" + encodeURIComponent(timestamp) + "&name=" + encodeURIComponent(name) + "&id=" + encodeURIComponent(id) + "&toId=" + encodeURIComponent(toId),true);
        xhr.send();
        inputField.value = "";
    });
    // let speech = new SpeechSynthesisUtterance();
    // let btn = document.getElementById("convert");
    // btn.addEventListener('click',function(){
    //     speech.text = inputField.value;
    //     window.speechSynthesis.speak(speech);
    // });
    let dropdown = document.getElementById("dropdown");
    dropdown.addEventListener("change",function(){
        let str = inputField.value;
        // morse code convert 
        // let morseCode  = Morse.encode(str);
        // console.log(morseCode);
        let xhr = new XMLHttpRequest();
        let timestamp = Date.now();
        let name = document.getElementById("name");
        let id = document.getElementById("id").textContent;
        console.log(id);
        xhr.onreadystatechange = function(){
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    document.getElementById("message").innerHTML = this.responseText;
                    localStorage.setItem("storedMessage", this.responseText);
                }
                else {
                        console.error("Error:", xhr.status);
                    }
            }
        }
        xhr.open("GET","server.php?msg=" + encodeURIComponent(str) + "&time=" + encodeURIComponent(timestamp) + "&name=" + encodeURIComponent(name) + "&id=" + encodeURIComponent(id) + "&toId=" + encodeURIComponent(toId),true);
        xhr.send();
        inputField.value = "";
    });
    </script>
</html>
