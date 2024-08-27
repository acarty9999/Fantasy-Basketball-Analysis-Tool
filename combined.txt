<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column; 
            justify-content: center;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form > div {
            margin-bottom: 10px;
        }

        label {
            margin-right: 10px;
        }

        .button-container { 
            margin-top: 10px;
        }
    </style>
</head>
<body>
    
    <form action="process-signup.php" method="post" id="signup" novalidate>
        <h1>Signup</h1>
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        
        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        
        <button type="submit">Sign up</button>
    </form>

    <div class="button-container">
        <a href="login.php">
            <button type="button">Login</button>
        </a>
    </div>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form > div {
            margin-bottom: 10px;
        }

        label {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    
    <form action="process-signup.php" method="post" id="signup" novalidate>
        <h1>Signup</h1>
    
    <p>Signup successful.
       You can now <a href="login.php">log in</a>.</p>
    
</body>
</html><?php

if (empty($_POST["name"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) == 0) {
    die("Please enter a password");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}







.popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border: 1px solid white;
    border-radius: 5px;
    padding: 20px;
    z-index: 9999; /*popup*/
    font-family: Montserrat, sans-serif;
}

.overlay {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5); /* transparency */
    z-index: 9998;
}


.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.popup-content {
    text-align: center;
}
.form-container2 {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px DimGray(0,0,0,0.1);
    width: 300px;
    position: absolute;
    right: -290%;
    top: 60px;
    box-sizing: border-box;
}

.form-container2 h2 {
    text-align: center;
    color: blue;
}

.input-field {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid grey;
    box-sizing: border-box;
}

.submit-button {
    width: 100%;
    padding: 10px;
    background-color: #0056b3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #004494;
}

.label {
    color: blue;
    display: block;
    margin-bottom: 5px;
}
.form-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px DimGray(0,0,0,0.1);
    width: 300px;
    position: relative;
    left: 0px;
    top: 60px;
    box-sizing: border-box;
}


.form-container h2 {
    text-align: center;
    color: blue;
}

.input-field {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid grey;
    box-sizing: border-box;
}

.submit-button {
    width: 100%;
    padding: 10px;
    background-color: #0056b3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: darkblue;
}

.label {
    color: blue;
    display: block;
    margin-bottom: 5px;
}
.form-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px DimGray(0,0,0,0.1);
    width: 300px;
    position: relative;
    left: -200px; /* Adjust as needed */
    top: 60px;
    box-sizing: border-box;
}


.form-container h2 {
    text-align: center;
    color: blue;
}

.input-field {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid grey;
    box-sizing: border-box;
}

.submit-button {
    width: 100%;
    padding: 10px;
    background-color: #0056b3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #004494;
}

.label {
    color: blue;
    display: block;
    margin-bottom: 5px;
}
// Function to toggle the form on the page
function toggleForm() {
    var formContainer = document.querySelector('.form-container');
    if (formContainer.style.display === 'hidden' || formContainer.style.display === '') {
        formContainer.style.display = 'visible';
    } else {
        formContainer.style.display = 'visible';
    }
}


// Function to close the popup form
function closePopupForm() {
    document.getElementById('popupForm').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

// Handle submissions for direct form
function submitPlayerNameDirect(event) {
    event.preventDefault();
    var playerName = document.getElementById('playerNameDirect').value;
    alert('Player\'s Name: ' + playerName);
    // Add any server interaction or further processing here
}

// Handle submissions for popup form
function submitPlayerNamePopup(event) {
    event.preventDefault();
    var playerName = document.getElementById('playerNamePopup').value;
    alert('Player\'s Name: ' + playerName);
    closePopupForm();
}
.navbar {
    background: darkgoldenrod;
    font-family: Arial;
    padding-right: 15px;
    padding-left: 15px;
    
}

*{
    text-decoration: none;
}

.navdiv {
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo1 img {
    max-width: 100px;
    height: auto;
}

.logo a {
    font-size: 35px;
    font-weight: 600;
}

li {
    list-style: none;
    display: inline-block;
}

li a {
    font-size: 18px;
    font-weight: bold;
    margin-right: 25px;
}

button {
    background-color: black;
    margin-left: 10px;
    border-radius: 10px;
    padding: 10px;
    width: 90px;
}

button a {
    color: white;
    font-weight: bold;
    size: 15px;
}
<?php
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column; 
            align-items: center;
            justify-content: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form > div {
            margin-bottom: 10px;
        }

        label {
            margin-right: 10px;
        }

        .button-container {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div>
        <form method="post">
            <h1>Login</h1>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
            </div>
            
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            
            <?php if ($is_invalid): ?>
                <em>Invalid login</em>
            <?php endif; ?>

            <button type="submit">Log in</button>
        </form>
    </div>

    <div class="button-container">
        <a href="signup.html">
            <button type="button">Sign Up</button>
        </a>
    </div>
    
</body>
</html>








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

    
    
    
    
    
    
    
    
    
    <?php

#HOME PAGE
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
    <!--HOME PAGE-->
    <title>Search Players</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="popup.css">
    <link rel="stylesheet" type="text/css" href="playerSearch1.css">
    <script src="playerScript.js"></script>
    <script src="teamScript.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: white;
            color: black;
        }

        .navbar {
            background: linear-gradient(to right, darkblue 55%, red);
            font-family: Arial;
            padding-right: 15px;
            padding-left: 15px;
            color: white;
            border-bottom: 2.5px solid black; /* to blur out top line */
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

    .buttons { /*form*/
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
        left: 0;
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
        left: 8%; 
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
        top: 30%;
        left: 10%;
        transform: translateY(-50%);
        font-family: Montserrat, sans-serif;
        font-size: 32.5px;
        color: white;
        padding-left: 20px;
        font-weight: thin;
        letter-spacing: 4px; 
    }


    </style>
</head>
<body>

<nav class="navbar">
    <div class="navdiv">
        <div class="logo1"><a href="index.php"><img src="FH.png" alt="FantasyHoopsInsight"></a></div>
        <div class="logo"><a href="index.php">FantasyHoopsInsight</a></div>
        <ul>
            <li><a href="test.php">Comps</a></li>
            <li><a href="insertTeam.php">Create Team</a></li>
            <li><a href="#">FAQ</a></li>
            <button><a href="logout.php">Logout</a></button>
        </ul>
    </div>
</nav>

<div class="container">
    <img src="lebron.PNG">
    <p class="subText">TIME TO BUILD YOUR TEAM</p>
    <p class="mainText">SEARCH FOR PLAYERS</p>
    <p class="opText">CHOOSE YOUR OPTION</p>
    <div class="buttons">

        <!-- FormS-->
    <div class="form-container">
    <h2>Search for Player</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="playerName" class="label">Enter Player's Name:</label>
        <input type="text" id="playerName" name="playerName" class="input-field" required>
        <input type="submit" value="Search" class="submit-button">
    </form>
    </div>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_name = $_POST['playerName'];

    $names = explode(' ', $player_name);
    $first_name = $names[0];
    $last_name = isset($names[1]) ? $names[1] : '';

    $ch = curl_init();

    //API ENDPs
    $url = 'http://api.balldontlie.io/v1/players?first_name=' . urlencode($first_name) . '&last_name=' . urlencode($last_name);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $api_key = '6d4362b0-4ac0-4868-85c6-144191ba6b96'; // my only api key
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $api_key
    ]);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    // ERROR CHECKer
    if ($response === false) {
        die('Error: ' . curl_error($ch));
    }

    $data = json_decode($response, true);

    if ($data === null) {
        die('Error decoding JSON: ' . json_last_error_msg());
    }

    if (!empty($data['data'])) {
        // GET PLAYER ID
        $player_id = $data['data'][0]['id'];

        $end_date = date('Y-m-d');
        //get last 7 days
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));

        $game_stats = array();

        $current_date = $end_date;
        while ($current_date >= $start_date) {
            // API endpoint URL
            $url = 'https://api.balldontlie.io/v1/stats?player_ids[]=' . $player_id . '&dates[]=' . $current_date;

            curl_setopt($ch, CURLOPT_URL, $url);
            $response = curl_exec($ch);

            if ($response === false) {
                die('Error: ' . curl_error($ch));
            }

            $data = json_decode($response, true);

            if ($data === null) {
                die('Error decoding JSON: ' . json_last_error_msg());
            }

            if (!empty($data['data'])) {
                $game_stats[$current_date] = $data['data'][0];
            }

            $current_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        }

        // Calc avgs
        $total_minutes = 0;
        $total_points = 0;
        $total_assists = 0;
        $total_rebounds = 0;
        $total_blocks = 0;
        $total_steals = 0;

        $num_games = count($game_stats);
        foreach ($game_stats as $stats) {
            $total_minutes += isset($stats['min']) ? $stats['min'] : 0;
            $total_points += isset($stats['pts']) ? $stats['pts'] : 0;
            $total_assists += isset($stats['ast']) ? $stats['ast'] : 0;
            $total_rebounds += isset($stats['reb']) ? $stats['reb'] : 0;
            $total_blocks += isset($stats['blk']) ? $stats['blk'] : 0;
            $total_steals += isset($stats['stl']) ? $stats['stl'] : 0;
        }

        // Calc avg
        $avg_minutes = round($total_minutes / $num_games, 1);
        $avg_points = round($total_points / $num_games, 1);
        $avg_assists = round($total_assists / $num_games, 1);
        $avg_rebounds = round($total_rebounds / $num_games, 1);
        $avg_blocks = round($total_blocks / $num_games, 1);
        $avg_steals = round($total_steals / $num_games, 1);

        // Display
        echo "<div style='display: table; margin: 50px auto 0;'>";
        echo "<div style='display: table; margin: -73px auto 0;'>";
        echo "<div style='display: table; left: 50px auto 0;'>";
        echo "<h2>Average Game Stats for $player_name (Last 7 Days)</h2>";
        echo "<div style='display: table; margin: 0;'>";
        echo "<div style='display: table-row;'>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Minutes</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Points</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Assists</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Rebounds</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Blocks</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Steals</div>";
        echo "</div>";
        echo "<div style='display: table-row;'>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_minutes</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_points</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_assists</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_rebounds</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_blocks</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_steals</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "No player found with the name: $player_name";
    }


    // Close cURL sess
    curl_close($ch);
}
?>


</body>
</html>

    
    
    
    
    
    
    
    
    
    <!DOCTYPE html>
<html>
<head>
    <!--HOME PAGE-->
    <title>Search Players</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="popup.css">
    <link rel="stylesheet" type="text/css" href="playerSearch1.css">
    <script src="playerScript.js"></script>
    <script src="teamScript.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: white;
            color: black;
        }

        .navbar {
            background: linear-gradient(to right, darkblue 55%, red);
            font-family: Arial;
            padding-right: 15px;
            padding-left: 15px;
            color: white;
            border-bottom: 2.5px solid black; /* to blur out top line */
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
        left: 0;
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
        left: 8%; 
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
        top: 30%;
        left: 10%;
        transform: translateY(-50%);
        font-family: Montserrat, sans-serif;
        font-size: 32.5px;
        color: white;
        padding-left: 20px;
        font-weight: thin;
        letter-spacing: 4px; 
    }


    </style>
</head>
<body>

<nav class="navbar">
    <div class="navdiv">
        <div class="logo1"><a href="index.php"><img src="FH.png" alt="FantasyHoopsInsight"></a></div>
        <div class="logo"><a href="index.php">FantasyHoopsInsight</a></div>
        <ul>
            <li><a href="test.php">Comps</a></li>
            <li><a href="#">View Team</a></li>
            <li><a href="#">FAQ</a></li>
            <button><a href="logout.php">Logout</a></button>
        </ul>
    </div>
</nav>

<div class="container">
    <img src="bronFDA.jpg">
    <p class="subText">TIME TO BUILD YOUR TEAM</p>
    <p class="mainText">SEARCH FOR PLAYERS</p>
    <p class="opText">CHOOSE YOUR OPTION</p>
    <div class="buttons">

        <!-- FormS-->
    <div class="form-container">
    <h2>Search for Player</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="playerName" class="label">Enter Player's Name:</label>
        <input type="text" id="playerName" name="playerName" class="input-field" required>
        <input type="submit" value="Search" class="submit-button">
    </form>
    </div>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $player_name = $_POST['playerName'];

    $names = explode(' ', $player_name);
    $first_name = $names[0];
    $last_name = isset($names[1]) ? $names[1] : '';

    $ch = curl_init();

    //API ENDS
    $url = 'http://api.balldontlie.io/v1/players?first_name=' . urlencode($first_name) . '&last_name=' . urlencode($last_name);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $api_key = '6d4362b0-4ac0-4868-85c6-144191ba6b96'; // Your API key
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $api_key
    ]);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    // ERROR CHECK
    if ($response === false) {
        die('Error: ' . curl_error($ch));
    }

    $data = json_decode($response, true);

    if ($data === null) {
        die('Error decoding JSON: ' . json_last_error_msg());
    }

    if (!empty($data['data'])) {
        // GET PLAYER ID
        $player_id = $data['data'][0]['id'];

        $end_date = date('Y-m-d');

        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));

        $game_stats = array();

        $current_date = $end_date;
        while ($current_date >= $start_date) {
            // API endpoint URL
            $url = 'https://api.balldontlie.io/v1/stats?player_ids[]=' . $player_id . '&dates[]=' . $current_date;

            curl_setopt($ch, CURLOPT_URL, $url);
            $response = curl_exec($ch);

            if ($response === false) {
                die('Error: ' . curl_error($ch));
            }

            $data = json_decode($response, true);

            if ($data === null) {
                die('Error decoding JSON: ' . json_last_error_msg());
            }

            if (!empty($data['data'])) {
                $game_stats[$current_date] = $data['data'][0];
            }

            $current_date = date('Y-m-d', strtotime('-1 day', strtotime($current_date)));
        }

        // Calc avgs
        $total_minutes = 0;
        $total_points = 0;
        $total_assists = 0;
        $total_rebounds = 0;
        $total_blocks = 0;
        $total_steals = 0;

        $num_games = count($game_stats);
        foreach ($game_stats as $stats) {
            $total_minutes += isset($stats['min']) ? $stats['min'] : 0;
            $total_points += isset($stats['pts']) ? $stats['pts'] : 0;
            $total_assists += isset($stats['ast']) ? $stats['ast'] : 0;
            $total_rebounds += isset($stats['reb']) ? $stats['reb'] : 0;
            $total_blocks += isset($stats['blk']) ? $stats['blk'] : 0;
            $total_steals += isset($stats['stl']) ? $stats['stl'] : 0;
        }

        // Calc avg
        $avg_minutes = round($total_minutes / $num_games, 1);
        $avg_points = round($total_points / $num_games, 1);
        $avg_assists = round($total_assists / $num_games, 1);
        $avg_rebounds = round($total_rebounds / $num_games, 1);
        $avg_blocks = round($total_blocks / $num_games, 1);
        $avg_steals = round($total_steals / $num_games, 1);

        // Display
        echo "<div style='display: table; margin: 50px auto 0;'>";
        echo "<div style='display: table; margin: -73px auto 0;'>";
        echo "<div style='display: table; left: 50px auto 0;'>";
        echo "<h2>Average Game Stats for $player_name (Last 7 Days)</h2>";
        echo "<div style='display: table; margin: 0;'>";
        echo "<div style='display: table-row;'>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Minutes</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Points</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Assists</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Rebounds</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Blocks</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>Steals</div>";
        echo "</div>";
        echo "<div style='display: table-row;'>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_minutes</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_points</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_assists</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_rebounds</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_blocks</div>";
        echo "<div style='display: table-cell; border: 1px solid black; padding: 10px; font-size: 20px;'>$avg_steals</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "No player found with the name: $player_name";
    }


    // Close cURL session
    curl_close($ch);
}
?>


</body>
</html>
<?php

$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;