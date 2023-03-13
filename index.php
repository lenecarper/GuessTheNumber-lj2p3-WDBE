<?php
    // Require the functions file to import external functions
    require('inc/functions.php');

    // Set a local variable to display a message when the page loads
    // In this case it's an explanation which displays the MIN/MAX guess values
    $message = "Guess a number between " . RAND_MIN . " and " . RAND_MAX . ". I will tell you whether your guess was too high, too low or correct.";

    // Store the secret number in a variable which is created when the page loads
    $correct_guess = correct_guess();

    // Check if the user has submitted a guess, increment the guess counter
    if (guess_submitted())
    {
        increment_guess_count();

        // Display different messages to the user after guessing depending on their answer
        if ($correct_guess && validate_number() == true)
        {
            $message = "You got it! It took you " . guess_count() . " attempts. Guess again?";
        } else if (guessed_low() && validate_number() == true)
        {
            $message = "Sorry, guess again but higher.";
        } else if (guessed_high() && validate_number() == true)
        {
            $message = "Sorry, guess again but lower.";
        // Make sure only numerical values are guessed
        } else if (guessed_high() or guessed_low() or $correct_guess && validate_number() == false)
        {
            $message = "Please only enter numerical values.";
        }
    }

    // Check if the secret number is set, the user has requested a reset or the user guessed the number correctly
    if (number_unset() || request_reset() || $correct_guess)
    {
        reset_secret_number();
        reset_guess_count();
    }
        
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Guess The Number</title>
    <link rel="stylesheet" href="style/style.css" />
</head>
<body>
    <h1 id="index-header">GUESS THE NUMBER</h1>
    <!-- Display a local message depending on the state of the game, saved in $_SESSION -->
    <p class="user-message"><?= $message ?></p>

    <!-- The form to guess the number in -->
    <div id="form-container">
        <form method="POST">
            <label for="user_guess" class="user-message">YOUR GUESS</label><br>
            <input id="user_guess" name="user_guess" class="guess-form" maxlength="3"><br><br>
            <input type="submit" name="guess" value="Guess" class="btn-guess">
            <input type="submit" name="reset" value="Reset" class="btn-reset">
        </form><br>
    </div>
    <div id="guess-container"><h1 class="previous-guess">Previous guess: <?= $last_guess ?><br><br>Secret number: <?= secret_number() ?></h1></div>
</body>
</html>
