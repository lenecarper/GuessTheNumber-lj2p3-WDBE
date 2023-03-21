<?php
    // Start a PHP session to store local variables
    session_start();

    initial();

    $last_guess = user_guess();
    $username = $_SESSION['username'];
    $minimum = $_SESSION['minimum'];
    $maximum = $_SESSION['maximum'];

    // Check the selected user settings
    // Make sure to upload these to the database later [!]

    function initial()
    {
        check_settings();
    }

    function check_settings()
    {
        if (isset($_POST['user_name']))
        {
            $_SESSION['username'] = $_POST['user_name'];
        }
        else
        {
            $_SESSION['username'] = "Player";
        }

        if (isset($_POST['user_minimum']))
        {
            $_SESSION['minimum'] = $_POST['user_minimum'];
        }
        else
        {
            $_SESSION['minimum'] = "1";
        }

        if (isset($_POST['user_maximum']))
        {
            $_SESSION['maximum'] = $_POST['user_maximum'];
        }
        else
        {
            $_SESSION['maximum'] = "100";
        }

        if (isset($_POST['user_tries']))
        {
            $_SESSION['tries'] = $_POST['user_tries'];
        }
        else
        {
            $_SESSION['tries'] = "15";
        }

        if (isset($_POST['user_time']))
        {
            $_SESSION['time'] = $_POST['user_time'];
        }
        else
        {
            $_SESSION['time'] = "120";
        }
    }

    // Check the user's submitted guess
    function guess_submitted()
    {
        return isset($_POST['guess']);
    }
    
    // Check if the user's guess is the same as the secret number
    function correct_guess()
    {
        return user_guess() == secret_number();
    }
    
    // Check if the user guessed too high
    function guessed_high()
    {
        return user_guess() > secret_number();
    }
    
    // Check if the user guessed too low
    function guessed_low()
    {
        return user_guess() < secret_number();
    }

    // Check if the user requested a reset through the reset button
    function request_reset()
    {
        return isset($_POST['reset']);
    }

    // Make sure all keys and conditions are set to prevent errors, otherwise return false
    function conditional_fetch($hash, $key)
    {
        if (isset($hash[$key])) {
            return $hash[$key];
        } else {
            return false;
        }
    }

    // Check the user's guess
    function user_guess()
    {
        return conditional_fetch($_POST, 'user_guess');
    }
    
    // Store the created random number in $_SESSION
    function secret_number()
    {
        return conditional_fetch($_SESSION, 'secret_number');
    }
    
    // Check if the secret number is set, return it as unset if not
    function number_unset()
    {
        return !isset($_SESSION['secret_number']);
    }
    
    // Create a random number between the set MIN/MAX values
    function reset_secret_number()
    {
        global $minimum, $maximum;
        $_SESSION['secret_number'] = rand($minimum, $maximum);
    }

    // Reset the user's guess count to 0
    function reset_guess_count()
    {
        $_SESSION['guess_count'] = 0;
    }
    
    // Increment the user's guess count after each confirmed guess
    function increment_guess_count()
    {
        $_SESSION['guess_count']++;
    }
    
    // Check the user's total amount of guesses and save it in $_SESSION
    function guess_count()
    {
        return conditional_fetch($_SESSION, 'guess_count'); 
    }

    function validate_number()
    {
        $number = $_POST['user_guess'];

        if (isset($_POST['guess']))
        {
            if(is_numeric($number))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    function quit_game()
    {
        return isset($_POST['quit']);
    }
?>
