<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logos/FH_Tran.PNG">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" type="text/css" href="comps.css">
    <title>Compare Players</title>
</head>
<body style="background: linear-gradient(to right, red 25%, darkblue 60%); overflow: hidden;">
    <header>
        <div style="background: linear-gradient(to right, red 25%, darkblue 60%);" class="navi-logo">
            <a href="home.php">
                <img src="/Logos/FH_Tran.png" alt="Logo" id="img1">
                <h2>FantasyHoopsInsight</h2>
            </a>
            <div class="links">
                <ul style="list-style: none;">
                    <li><a href="createTeam.php">Create Teams</a></li>
                    <li><a href="home.php">Search Players</a></li>
                    <li><a href="logout.php" id="logout-link">Log Out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <p class="page2_msg">GET COMPETITIVE</p>
    <p class="page2_msg" id="msg2">COMPARE & ANALYZE</p>
    <p class="page2_msg">CHOOSE YOUR PLAYERS</p>

    <form method="POST" action="" class="compare-form">
        <div class="player-input">
            <label for="player_name_1">Enter Player 1 Name:</label><br>
            <input type="text" id="player_name_1" name="player_name_1" required><br>
            <input type="submit" value="Compare">
        </div>

        <div class="player-input">
            <label for="player_name_2">Enter Player 2 Name:</label><br>
            <input type="text" id="player_name_2" name="player_name_2" required><br>
            <input type="submit" value="Compare">
        </div>
    </form>

    <?php
    function displayPlayerStats($player_name) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://tank01-fantasy-stats.p.rapidapi.com/getNBAPlayerList",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: tank01-fantasy-stats.p.rapidapi.com",
                "x-rapidapi-key: ca2a498077msh6d1c24ee3645dfdp146ea1jsnc128ef5779a4"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            return;
        } else {
            $players = json_decode($response, true);
            $player_id = null;

            foreach ($players['body'] as $player) {
                if (strtolower($player['longName']) == strtolower($player_name)) {
                    $player_id = $player['playerID'];
                    break;
                }
            }

            if (!$player_id) {
                echo "<h3>Player not found. Please try again.</h3>";
                return;
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://tank01-fantasy-stats.p.rapidapi.com/getNBAGamesForPlayer?playerID=$player_id&season=2025&fantasyPoints=true",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: tank01-fantasy-stats.p.rapidapi.com",
                    "x-rapidapi-key: ca2a498077msh6d1c24ee3645dfdp146ea1jsnc128ef5779a4"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
                return;
            }

            $games = json_decode($response, true);
            if (isset($games['body']) && !empty($games['body'])) {
                $total_games = count($games['body']);
                $total_pts = $total_ast = $total_reb = $total_stl = $total_blk = $total_to = $total_mins = $total_fp = 0;

                foreach ($games['body'] as $game) {
                    $pts = $game['pts'] ?? 0;
                    $ast = $game['ast'] ?? 0;
                    $reb = $game['reb'] ?? 0;
                    $stl = $game['stl'] ?? 0;
                    $blk = $game['blk'] ?? 0;
                    $to = $game['to'] ?? 0;
                    $mins = $game['mins'] ?? 0;

                    $fgm = $game['fgm'] ?? 0;
                    $fga = $game['fga'] ?? 0;
                    $ftm = $game['ftm'] ?? 0;
                    $fta = $game['fta'] ?? 0;
                    $three_pm = $game['three_pm'] ?? 0;

                    $fantasy_points = ($fgm * 2) - $fga + ($ftm * 1) - $fta + ($three_pm * 1) + ($reb * 1) + ($ast * 2) + ($stl * 4) + ($blk * 4) - ($to * 2) + ($pts * 1);

                    $total_pts += $pts;
                    $total_ast += $ast;
                    $total_reb += $reb;
                    $total_stl += $stl;
                    $total_blk += $blk;
                    $total_to += $to;
                    $total_mins += $mins;
                    $total_fp += $fantasy_points;
                }

                $avg_fp = $total_fp / $total_games;
                $avg_mins = $total_mins / $total_games;
                $avg_ppg = $total_pts / $total_games;
                $avg_apg = $total_ast / $total_games;
                $avg_rpg = $total_reb / $total_games;
                $avg_spg = $total_stl / $total_games;
                $avg_bpg = $total_blk / $total_games;

                echo "<h3 style='font-size: 2em;color: white; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;'>" . htmlspecialchars($player_name) . " (Season 24-25)</h3>";
                echo "<div style='font-size: 1.5em; color: white; text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;'>";
                echo "<b>Fantasy:</b> " . number_format($avg_fp, 1) . "<br>";
                echo "<b>MinPG:</b> " . number_format($avg_mins, 1) . "<br>";
                echo "<b>PPG:</b> " . number_format($avg_ppg, 1) . "<br>";
                echo "<b>APG:</b> " . number_format($avg_apg, 1) . "<br>";
                echo "<b>RPG:</b> " . number_format($avg_rpg, 1) . "<br>";
                echo "<b>SPG:</b> " . number_format($avg_spg, 1) . "<br>";
                echo "<b>BPG:</b> " . number_format($avg_bpg, 1) . "<br>";
                echo "</div>";
            } else {
                echo "<h3>No stats found for this player for the 2025 season.</h3>";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<div style='display: flex; justify-content: space-around; margin-top: 20px;'>";

        if (!empty($_POST['player_name_1'])) {
            echo "<div>";
            displayPlayerStats(trim($_POST['player_name_1']));
            echo "</div>";
        }

        if (!empty($_POST['player_name_2'])) {
            echo "<div>";
            displayPlayerStats(trim($_POST['player_name_2']));
            echo "</div>";
        }

        echo "</div>";
    }
    ?>
</body>
</html>