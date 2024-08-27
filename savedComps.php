<!DOCTYPE html>
<html>
<head>
    <!--HOME PAGE-->
    <title>savedComps</title>
    <meta charset="UTF-8">
    <style>
        body, html {
    	height: 100%;
    	margin: 0;
    	display: flex;
    	justify-content: center;
    	align-items: flex-start; 
    	background-color: white;
    	color: black;
	}

	h1, #links {
    	text-align: center; 
	     margin-top: 20px; 
	}

        a {
            color: blue; 
        }
    </style>
</head>
<body>
	<style type= "text/css">
		*{
			text-decoration: none;
		}
		.navbar{
			background: darkgoldenrod; font-family: Arial; padding-right: 15px; padding-left: 15px;
		}
		.navdiv{
			display: flex; align-items: center; justify-content: space-between;
		}
		
		.logo1 img {
    		max-width: 100px;
    		height: auto;
		}

		.logo a{
			font-size: 35px; font-weight: 600; color: white;
		}

		li{
			list-style: none; display: inline-block; 
		}
		li a{
			color: white; font-size: 18px; font-weight: bold; margin-right: 25px; 
		}
		button{
			background-color: black; margin-left: 10px; border-radius: 10px; padding: 10px; width: 90px;
		}
		button a{
			color: white; font-weight: bold; size: 15px;
		}
    </style>

	<nav class = "navbar">
		<div class="navdiv">
			<div class="logo1"><a href="index.php"><img src="FH.png" alt="FantasyHoopsInsight"></a></div>
			<div class="logo"><a href="index.php">FantasyHoopsInsight</a></div>
			<ul>
				<li><a href="#">Delete Comps</a></li>
				<button><a href="logout.php">Logout</a></button>
			</ul>
		</div>
    </body>
</html>