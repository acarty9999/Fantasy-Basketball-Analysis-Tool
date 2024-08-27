<?php
session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <!--Insert team PAGE-->
    <title>Insert Team</title>
    <meta charset="UTF-8">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: white;
            color: black;
        }

        .navbar {
            background: linear-gradient(to left, darkblue 45%, red);
            font-family: Arial;
            padding-right: 15px;
            padding-left: 15px;
            color: white;
            border-bottom: 2.5px solid black; /* separate*/
        }

        .navdiv {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo1 img {
            max-width: 100px;
            height: auto;
        }

        .logo a {
            font-size: 35px;
            font-weight: 600;
            font-family: Gotham, sans-serif;
            color: white;
        }

        li {
            list-style: none;
            display: inline-block; 
        }

        li a {
            color: white;
            font-size: 18px;
            font-weight: bold;
            margin-right: 25px; 
        }

        button {
            background-color: white;
            margin-left: 10px;
            border-radius: 10px;
            padding: 10px;
            width: 90px;
            color: black;
            font-weight: bold;
            size: 15px;
            cursor: pointer;
            text-align: center;
        }

        .container {
            position: relative;
        }

        .container img {
            display: block;
            width: 100%;
            height: auto;
        }

        .button {
        display: inline-block;
        background-color: white;
        border: none;
        color: black;
        text-align: center;
        font-size: 16px;
        padding: 10px 24px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 8px;
        width: auto;
    }

    .button:hover {
        background-color: blue;
        color: white;
    }

    .buttons {
        position: absolute;
        top: 50%;
        left: 27%;
        transform: translate(-50%, -50%);
    }

    .buttons button {
        margin: 10px;
     }

    .prompt {
        text-align: center;
        margin-top: 20px;
    }

    a {
        text-decoration: none; 
    }

    .mainText {
        position: absolute;
        top: 10%;
        left: 20%;
        transform: translateY(-50%);
        font-family: Montserrat, sans-serif;
        font-size: 65px;
        color: white;
        padding-left: 20px; 
        font-weight: bold;
    }

    .subText {
        position: absolute;
        top: 0%;
        left: 31%; 
        transform: translateY(-50%);
        font-family: Montserrat, sans-serif;
        font-size: 32.5px;
        color: white;
        padding-left: 20px; 
        font-weight: thin;
        letter-spacing: 4px; 
    }

    .opText {
        position: absolute;
        top: 25%;
        left: 33.5%;
        transform: translateY(-50%);
        font-family: Montserrat, sans-serif;
        font-size: 32.5px;
        color: white;
        padding-left: 20px;
        font-weight: thin;
        letter-spacing: 4px; 
    }

	.form-container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border: 2px solid darkblue;
            border-radius: 10px;
			transform: translateX(90%); /*FINALLY MOVES IT*/
        }

        .input-field {
            padding: 10px;
            border: 1px solid darkblue;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .submit-button {
            background-color: darkblue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .results-container {
            margin: 40px auto;
            width: 300px;
			left: 60%;
            text-align: center;
			font-family: Montserrat, sans-serif;
        	font-size: 35px;
        	color: white;
        	padding-left: 20px; 
        	font-weight: bold;
			transform: translateX(90%);
        }


    </style>
</head>
<body>

<nav class="navbar">
    <div class="navdiv">
        <div class="logo1"><a href="index.php"><img src="FH.png" alt="FantasyHoopsInsight"></a></div>
        <div class="logo"><a href="index.php">FantasyHoopsInsight</a></div>
        <ul>
            <li><a href="index.php">Search Players</a></li>
            <li><a href="test.php">Comps</a></li>
            <li><a href="#">FAQ</a></li>
            <button><a href="logout.php">Logout</a></button>
        </ul>
    </div>
</nav>

<div class="container">
    <img src="kdmel.PNG">
    <p class="subText">KEEP TRACK OF YOUR STARS</p>
    <p class="mainText">CREATE YOUR SUPERTEAM</p>
    <p class="opText">CHOOSE YOUR PLAYERS</p>
    <div class="buttons">


	<div class="form-container">
    	<h2>Enter Player Name</h2>
    	<form id="playerForm">
        	<input type="text" id="playerInput" class="input-field" placeholder="Enter Player Name" required>
        	<button class="submit-button" type="button" onclick="addPlayer()">Add</button>
    	</form>
	</div>

	<div class='results-container' id='results'></div>

</div>

<script>
let player_names = [];

function addPlayer() {
    const input = document.getElementById("playerInput");
    const player_name = input.value.trim();

    if (player_name) {
        player_names.push(player_name);

        if (player_names.length < 5) {
            input.value = ""; // Clear
        } else {
            displayPlayers(); // show 5
        }
    }
}

function displayPlayers() {
    const resultsDiv = document.getElementById("results");
    resultsDiv.innerHTML = ""; //Clea

    player_names.forEach(name => {
        const item = document.createElement("div");
        item.className = "result-item";
        item.textContent = name;
        resultsDiv.appendChild(item);
    });

    document.querySelector(".form-container").style.display = "none"; //HidEn
}
</script>

</body>
</html>

    
    
    
    
    
    
    
    
    
    