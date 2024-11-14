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
            
            header("Location: home.php");
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








