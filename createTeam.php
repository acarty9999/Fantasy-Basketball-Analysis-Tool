<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logos/FH_Tran.PNG">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" type="text/css" href="pForm.css">
    <link rel="stylesheet" type="text/css" href="createTeam.css">
    <title>Create Team</title>
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
                    <li><a href="comps.php">Comps</a></li>
                    <li><a href="home.php">Search Players</a></li>
                    <li><a href="logout.php" id="logout-link">Log Out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <p class="page2_msg">KEEP TRACK OF FUTURE STARS</p>
    <p class="page2_msg" id="msg2">CREATE YOUR SUPERTEAM</p>
    <p class="page2_msg">CHOOSE YOUR PLAYERS</p>

    <span>
        <img src="/bg-images/kd2.png" alt="kd" class="bgIMG" style="float: left;">
        <img src="/bg-images/rw1.png" alt="rw" class="bgIMG" style="float: right;">
    </span>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $players = [
            $_POST['player1'] ?? '',
            $_POST['player2'] ?? '',
            $_POST['player3'] ?? '',
            $_POST['player4'] ?? '',
            $_POST['player5'] ?? '',
        ];

        echo "<div class='player-list' style='text-align: center; margin-top: 20px;'>";
        foreach ($players as $player) {
            if (!empty($player)) {
                echo "<p>$player</p>";
            }
        }
        echo "</div>";

        echo "<div style='text-align: center; margin-top: 20px;'>
                <form action=''>
                    <button type='submit' class='button'>Reset</button>
                </form>
              </div>";
    } else {
        echo "
        <form method='POST' action='' style='text-align: center; margin-top: 20px;'>
            <div class='input-container'>
                <input type='text' name='player1' placeholder='Player 1'><br>
                <input type='text' name='player2' placeholder='Player 2'><br>
                <input type='text' name='player3' placeholder='Player 3'><br>
                <input type='text' name='player4' placeholder='Player 4'><br>
                <input type='text' name='player5' placeholder='Player 5'><br>
                <button type='submit' class='button'>Submit</button>
                <button type='submit' class='button'>Reset</button>
            </div>
        </form>
        ";
    }
    ?>
</body>
</html>