<?php
    // Require the functions file to import external functions
    require('../inc/functions.php');
    // Set a local variable to display a message when the page loads
    // In this case it's an explanation which displays the MIN/MAX guess values
    $minimum = $_SESSION['minimum'];
    $maximum = $_SESSION['maximum'];
    $tries = $_SESSION['tries'];
    $instruction = "Guess a number between " . $minimum . " and " . $maximum . ". I will tell you whether your guess was too high, too low or correct.";
    $_SESSION['message'] = "Enter a number below";
    $message = $_SESSION['message'];

    // Store the secret number in a variable which is created when the page loads
    $correct_guess = correct_guess();

    // Check if the user has submitted a guess, increment the guess counter
    if (guess_submitted())
    {
        increment_guess_count();

        // Display different messages to the user after guessing depending on their answer
        if ($correct_guess && validate_number() == true)
        {
            $_SESSION['message'] = "You got it! It took you " . guess_count() . " attempts. Your score has been uploaded to the leaderboards.";
            $_SESSION['winner'] = true;
        }
        else if (isset($_POST['guess']) && $_SESSION['winner'] == true)
        {
            uploadScore();
            $_SESSION['winner'] = false;
        }
        else if (guessed_low() && validate_number() == true)
        {
            $_SESSION['message'] = "Sorry, guess again but higher.";
        }
        else if (guessed_high() && validate_number() == true)
        {
            $_SESSION['message'] = "Sorry, guess again but lower.";
        // Make sure only numerical values are guessed
        }
        else if (guessed_high() or guessed_low() or $correct_guess && validate_number() == false)
        {
            $_SESSION['message'] = "Please only enter numerical values.";
        }
        else if ($_SESSION['tries'] == 0)
        {
            $_SESSION['message'] = "Out of tries.";
        }
    }

    // Check if the secret number is set, the user has requested a reset or the user guessed the number correctly
    if (number_unset() || request_reset() || $correct_guess)
    {
        reset_secret_number();
        reset_guess_count();
        check_settings();
    }    
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Guess The Number</title>
    <!-- Load stylesheet and countdown script -->
    <link rel="stylesheet" href="../style/style.css" />
</head>
<body>
    <h1 id="index-header">Guess the number, <?= $_SESSION['username'] ?></h1>
    <!-- Display a local message depending on the state of the game, saved in $_SESSION -->
    <p class="user-message"><?= $instruction ?></p><br>
    <!-- <p id="countdown-time"></p> -->
    <p class="user-message"><?= $_SESSION['message'] ?></p>

    <!-- The form to guess the number in -->
    <div id="form-container">
        <form method="POST">
            <label for="user_guess" class="user-message">YOUR GUESS</label><br>
            <input id="user_guess" name="user_guess" class="guess-form" maxlength="4"><br><br>
            <input type="submit" name="guess" value="Guess" class="btn-guess" <?php if ($_SESSION['tries'] == 0) { ?> disabled <?php } ?>/>
            <input type="submit" name="reset" value="Reset" class="btn-reset" />
            <input type="submit" name="quit" value="Quit" class="btn-quit" />
        </form><br>
    </div>
    <?php
    if (isset($_SESSION['sessionInfo']))
    {
        if($_SESSION['sessionInfo'] == true)
        {
            check_display($_SESSION);
        }
        else
        {
            $_SESSION['sessionInfo'] = false;
        }
    } ?>
    <div id="guess-container">
        <h1 class="previous-guess">Previous guess: <?= $last_guess ?><br><br>Secret number: <?= secret_number() ?><br>Tries: <?= $tries ?></h1>
        <div id="leaderboard-container">
            <?php getScore(); ?>
        </div>
    </div>
</body>
</html>
