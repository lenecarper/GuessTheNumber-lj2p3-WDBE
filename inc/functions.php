<?php
    // Start a PHP session to store local variables
    session_start();

    $last_guess = user_guess();
    $username = "";

    // Define the minimum and maximum numbers to guess between
    define("RAND_MIN", 1);
    define("RAND_MAX", 100);


    // // Check whether the guessed number is a numeric value
    // function valid_last_guess()
    // {
    //     if (is_numeric($last_guess))
    //     {
    //         $last_guess = 
    //     }
    // }
    //
    // function active_timer()
    // {
    //
    // }

    // Check the selected user settings
    // Make sure to upload these to the database later [!]
    function check_settings()
    {
        $username = $_POST['user_name'];
        return isset($_POST['user_name']);
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
        $_SESSION['secret_number'] = rand(RAND_MIN, RAND_MAX);
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
