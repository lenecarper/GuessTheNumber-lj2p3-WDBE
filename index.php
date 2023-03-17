<?php
    // Require the functions file to import external functions
    require('inc/functions.php'); 
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Guess The Number</title>
    <link rel="stylesheet" href="style/style.css" />
</head>
<body>
    <h1 id="index-header">SETTINGS</h1>   
    <div id="settings-outer">
        <div id="settings-container">
            <form method="POST">
                <label for="user_name" class="user-message">Your name</label><br>
                <input id="user_name" name="user_name" class="settings-form" maxlength="20"><br><br>
                <label for="user_minimum" class="user-message">Minimum number</label><br>
                <input id="user_minimum" name="user_minimum" class="settings-form" maxlength="4"><br><br>
                <label for="user_maximum" class="user-message">Maximum number</label><br>
                <input id="user_maximum" name="user_maximum" class="settings-form" maxlength="4"><br><br>
                <label for="user_tries" class="user-message">Amount of tries</label><br>
                <input id="user_tries" name="user_tries" class="settings-form" maxlength="3"><br><br>
                <label for="user_time" class="user-message">Time in seconds</label><br>
                <input id="user_time" name="user_time" class="settings-form" maxlength="4"><br><br>
                <label for="user_check" class="user-message">Display settings in the game</label><br>
                <input id="user_check" name="user_check" class="settings-form" type="checkbox"><br><br>
            </form>
        </div>
    </div>
</body>
</html>
