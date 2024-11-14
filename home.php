<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logos/FH_Tran.PNG">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" type="text/css" href="pForm.css">
    <title>Search For Players</title>
</head>
<body>
    <header>
        <div class="navi-logo">
            <a href="home.php">
            <img src="/Logos/FH_Tran.png" alt="Logo" id="img1">
            <h2>FantasyHoopsInsight</h2>
            </a>
            <div class="links">
                <ul style="list-style: none;">
                    <li><a href="comps.php">Comps</a></li>
                    <li><a href="createTeam.php">Create Team</a></li>
                    <li><a href="logout.php" id="logout-link">Log Out</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <span>
        <img src="/bg-images/bron9.png" alt="Lebron" id="bg-image1">
    </span>
    <p class="page1_msg">TIME TO BUILD YOUR TEAM</p>
    <p class="page1_msg" id="msg1">SEARCH FOR PLAYERS</p>
    <p class="page1_msg">CHOOSE YOUR OPTION</p>

    <div class="flex">
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerName = $_POST['pName'];

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
            if (strtolower($player['longName']) == strtolower($playerName)) {
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
            $total_pts = $total_ast = $total_reb = $total_stl = $total_blk = $total_to = 0;

            foreach ($games['body'] as $game) {
                $total_pts += $game['pts'] ?? 0;
                $total_ast += $game['ast'] ?? 0;
                $total_reb += $game['reb'] ?? 0;
                $total_stl += $game['stl'] ?? 0;
                $total_blk += $game['blk'] ?? 0;
                $total_to += $game['to'] ?? 0;
            }

            //avsg
            $avg_ppg = $total_pts / $total_games;
            $avg_apg = $total_ast / $total_games;
            $avg_rpg = $total_reb / $total_games;
            $avg_spg = $total_stl / $total_games;
            $avg_bpg = $total_blk / $total_games;
            $avg_tog = $total_to / $total_games;
        } else {
            $avg_ppg = $avg_apg = $avg_rpg = $avg_spg = $avg_bpg = $avg_tog = "N/A";
        }
    }
}
?>

<div class="form-container">
    <form class="form1" action="#popup2" method="post">
        <label for="pName" id="playerName">Search For Player:</label>
        <br>
        <input type="text" id="pName" name="pName" placeholder="Stephen Curry">
        <input type="submit" id="submit">
    </form>
</div>

<div id="popup2" class="popup">
    <div class="popup-content">
        <a href="#" class="close">&times;</a>
        <?php if (isset($playerName)): ?>
            <h2 style="text-align: center; font-size: 2em;"><?php echo htmlspecialchars($playerName); ?></h2>
            <table style="width: 100%; text-align: center; font-size: 2em;">
                <tr>
                    <th>PPG</th>
                    <th>APG</th>
                    <th>RPG</th>
                    <th>SPG</th>
                    <th>BPG</th>
                </tr>
                <tr>
                    <td><?php echo number_format($avg_ppg, 1); ?></td>
                    <td><?php echo number_format($avg_apg, 1); ?></td>
                    <td><?php echo number_format($avg_rpg, 1); ?></td>
                    <td><?php echo number_format($avg_spg, 1); ?></td>
                    <td><?php echo number_format($avg_bpg, 1); ?></td>
                </tr>
            </table>
        <?php else: ?>
            <h2 style="text-align: center;">Player data couldn't be found</h2>
        <?php endif; ?>
    </div>
</div>

        <div class="form-container">
            <form class="form1" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                <a href="#popup" class="button">Select Team</a>
            </form>
        </div>

        <!--Replace old API with new-->
        <div id="popup" class="popup">
            <div class="popup-content">
                <a href="#" class="close">&times;</a>
                <div class="popMsg">
                    <h2 style="color:white;">NBA Teams</h2>
                    <p>
                        <?php
                            $teamNames = [
                                "Hawks", "Celtics", "Nets", "Hornets", "Bulls", 
                                "Cavaliers", "Mavericks", "Nuggets", "Pistons", 
                                "Warriors", "Rockets", "Pacers", "Clippers", 
                                "Lakers", "Grizzlies", "Heat", "Bucks", 
                                "Timberwolves", "Pelicans", "Knicks", 
                                "Thunder", "Magic", "76ers", "Suns"
                            ];

                            $apiKey = '6d4362b0-4ac0-4868-85c6-144191ba6b96';

                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_URL, "https://api.balldontlie.io/v1/teams");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: ' . $apiKey
                            ));

                            $response = curl_exec($ch);

                            if (curl_errno($ch)) {
                                echo 'Error:' . curl_error($ch);
                            }

                            curl_close($ch);

                            $teams = json_decode($response, true);

                            if (!empty($teams['data'])) {
                                echo '<div class="flex">';
                                foreach ($teams['data'] as $team) {
                                    if (in_array($team['name'], $teamNames)) {
                                        echo '<div class="team">';
                                        echo '<a href="#team-' . $team['id'] . '" class="team-link">';
                                        echo '<h3>' . $team['full_name'] . '</h3>';
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            } else {
                                echo '<p style="color:white;">API ISSUES.</p>';
                                echo '<pre>';
                                print_r($teams);
                                echo '</pre>';
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!--Replace old API with new soon-->
        <?php
        if (!empty($teams['data'])) {
            foreach ($teams['data'] as $team) {
                if (in_array($team['name'], $teamNames)) {
                    echo '<div id="team-' . $team['id'] . '" class="popup">';
                    echo '<div class="popup-content">';
                    echo '<a href="#" class="close">&times;</a>';
                    echo '<div class="popMsg">';
                    echo '<h2 style="color:white;">Copy Player\'s Name</h2>';
                    echo '<p>';

                    $players_url = "https://api.balldontlie.io/v1/players?team_ids[]=" . $team['id'];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $players_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $apiKey));
                    $players_response = curl_exec($ch);
                    curl_close($ch);

                    $players = json_decode($players_response, true);

                    if (!empty($players['data'])) {
                        echo '<ul style="list-style-type: none; padding: 0; margin: 0;class="player-list">';
                        foreach ($players['data'] as $player) {
                            echo '<li style="color:white;">' . $player['first_name'] . ' ' . $player['last_name'] . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>No players found or issue with API request.</p>';
                    }

                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
        ?>

    </div>
</body>
</html>