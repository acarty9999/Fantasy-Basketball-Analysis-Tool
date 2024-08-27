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
