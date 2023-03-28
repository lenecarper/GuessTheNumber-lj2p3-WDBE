<?php
    // Require the functions file to import external functions
    require('inc/functions.php'); 
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Guess The Number</title>
    <link rel="stylesheet" href="style/style.css" />
    <script src="inc/main.js" /></script>
</head>
<body>
    <!-- <br><br><h1 id="index-header">SETTINGS</h1>   
    <div id="settings-outer">
        <div id="settings-container">
            <form method="POST" action="pages/play.php">
                <label for="user_name" class="user-message">Your name</label><br>
                <label for="user_minimum" class="user-message">Minimum number</label><br>
                <input id="user_minimum" name="user_minimum" class="settings-form" maxlength="4" type="number" required><br><br>
                <label for="user_maximum" class="user-message">Maximum number</label><br>
                <input id="user_maximum" name="user_maximum" class="settings-form" maxlength="4" type="number" required><br><br>
                <label for="user_tries" class="user-message">Amount of tries</label><br>
                <input id="user_tries" name="user_tries" class="settings-form" maxlength="3" type="number" required><br><br>
                <label for="user_time" class="user-message">Time in seconds</label><br>
                <input id="user_time" name="user_time" class="settings-form" maxlength="4" type="number" required><br><br>
                <label for="user_check" class="user-message">Display settings in the game</label><br>
            </form>
        </div>
    </div> -->
<div id="settings-form">
  <!-- Settings form -->
  <form method="POST" action="pages/play.php">
    <div class="flex row w-100 ml-2" style="max-width: 800px;">
      <div class="column w-65 p-1">
        <h2 class="play-once">PLAYER SETTINGS (REQUIRED)</h2>
        <div class="row w-100">
          <div class="field w-59">
            <label class="glow text">Name</label>
            <input id="user_name" name="user_name" class="settings-form" maxlength="20" required><br><br>
          </div>
          <div class="field">
                <label class="glow text">Display settings</label>
                <input id="user_check" name="user_check" class="user-check" type="checkbox"><br><br>
            </div>
        </div>
        <h2>GAME SETTINGS (REQUIRED)</h2>
        <div class="yellow mb-1">
          <div class="flex row w-100 justify-space-between">
            <div class="field w-24">
                <label class="glow text">Minimum Number</label>
                <input id="user_minimum" name="user_minimum" class="settings-form" maxlength="4" type="number" required><br><br>
            </div>
            <div class="field w-24">
                <label class="glow text">Maximum Number</label>
                <input id="user_maximum" name="user_maximum" class="settings-form" maxlength="4" type="number" required><br><br>
            </div>
            <div class="field w-24">
                <label class="glow text">Tries</label>
                <input id="user_tries" name="user_tries" class="settings-form" maxlength="3" type="number" required><br><br>
            </div>
            <div class="field w-24">
                <label class="glow text">Time (in seconds)</label>
                <input id="user_time" name="user_time" class="settings-form" maxlength="4" type="number" required><br><br>
            </div>
        </div><br>
        <h2></h2>
        <div class="flex row mt-1">
          <input id="user_submit" name="user_submit" class="green" type="submit" value="Opslaan">
        </div>
      </div>
    </div>
  </form>
</div>
</body>
</html>