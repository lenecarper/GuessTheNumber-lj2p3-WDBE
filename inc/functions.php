<?php
    // Start a PHP session to store local variables
    session_start();

    init();

    # Define global variables
    $last_guess = user_guess();
    $_SESSION['display'] = false;
    $display = $_SESSION['display'];
    $message = "";
    $_SESSION['winner'] = false;
    $errors = array();
    $_SESSION['startTime'] = time();

    function init()
    {
        check_settings();
        quit_game();
        $_SESSION['winner'] = false;
    }

    function check_settings()
    {
        $_SESSION['locked'] = 0;
        if (isset($_POST['user_name']) && $_SESSION['locked'] !== 1)
        {
            $_SESSION['username'] = $_POST['user_name'];
        }

        if (isset($_POST['user_minimum']) && is_numeric($_POST['user_minimum']))
        {
            $_SESSION['minimum'] = $_POST['user_minimum'];
        }

        if (isset($_POST['user_maximum']) && is_numeric($_POST['user_maximum']))
        {
            $_SESSION['maximum'] = $_POST['user_maximum'];
        }

        if (isset($_POST['user_tries']) && is_numeric($_POST['user_tries']))
        {
            $_SESSION['tries'] = $_POST['user_tries'];
        }

        if (isset($_POST['user_time']) && is_numeric($_POST['user_time']))
        {
            $_SESSION['time'] = $_POST['user_time'];
        }

        if (isset($_POST['user_check']))
        {
            $_SESSION['sessionInfo'] = true;
        }

        if (isset($_POST['user_time']) && is_numeric($_POST['user_time']))
        {
            $_SESSION['time'] = $_POST['user_time'];
            $_SESSION['startTime'] = false;
        }
        if(!isset($_SESSION['elapsedTime']))
        {
            $_SESSION['elapsedTime'] = false;
        }
        else
        {
            $_SESSION['elapsedTime'] = (time() - $_SESSION['startTime']);
        }
    }

    function check_display($display)
    {
        echo "<pre>";
        var_dump($display, true);
        echo "</pre>";
    }

    // Check the user's submitted guess
    function guess_submitted()
    {
        if (isset($_POST['guess']) && $_SESSION['tries'] > 0 && $_POST['guess'] != null)
        {
            $_SESSION['tries']--;
            // Currently not updating in realtime to prevent session variables getting deleted
            // header("Refresh:0");
        }
        else if (isset($_POST['guess']) && $_SESSION['tries'] == 0)
        {
            $_SESSION['tries'] = 0;
            $_SESSION['message'] = "Out of tries!";
        }
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
        $_SESSION['secret_number'] = rand($_SESSION['minimum'], $_SESSION['maximum']);
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
        if (isset($_POST['quit']))
        {
            header("location:../index.php");
            session_destroy();

            if (isset($_SESSION))
            {
                init();
            }
            else
            {
                session_start();
            }
        }
    }

    function db()
    { // Connect to the MySQL database
    $db = new mysqli('localhost', 'root', '', 'guessthenumber');

    // Checks the connection
    if($db -> connect_errno)
    {
        echo "Connection failed " . $db -> connect_error;
        array_push($errors, "The database has ran into a critical problem.");
        echo $errors;
        exit();
    }

    // Return the database status
    return $db;
    }

    # Function to retrieve and upload the data into the database
    function uploadScore()
    {
        // Check if there is a POST request
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {            
            # Define variables
            $db = db();
            $username = $_SESSION['username'];
            $minimum = $_SESSION['minimum'];
            $maximum = $_SESSION['maximum'];
            $tries = $_SESSION['tries'];
            $time = $_SESSION['time'];

            global $errors;
            # Gather all the data into an SQL query
            if (isset($_POST['guess']))
            {
                $upload = "INSERT into highscores (`username`, `minimum`, `maximum`, `tries`, `time`) VALUES ('$username', '$minimum', '$maximum', '$tries', '$time')";
                # Query the data to be sent into the corresponding database tables
                $query = $db->query($upload) or die($db->error);
                header("location:play.php");
            } else
            {
                array_push($errors, "An error has occured, please try again.");
                echo $errors;
            }
        }
    }

    function getScore()
    {   // Connect to the SQL database
        $db = db();

        $data = 'SELECT * from highscores ORDER BY `time` ASC, `tries` ASC LIMIT 8';
        $result = $db->query($data) or die($db->error);
        // Insert all stored data into the database
        $score = $result->fetch_all(MYSQLI_ASSOC);
        // Check if there are any objects in the database
        if (count($score) > 0)
        { // Loop through all the highscores and print them out into the leaderboard
        foreach($score as $point) 
        {
            echo "<div class='leaderboard-username'>" . $point["username"] . "</div>" . " ";
            if ($point["time"] == 1)
            {
                echo "<div class='leaderboard-time'>" . $point["time"] . " second" ."</div>" . " ";
            }
            else
            {
                echo "<div class='leaderboard-time'>" . $point["time"] . " seconds" ."</div>" . " ";
            }
            if ($point["tries"] == 1)
            {
                echo "<div class='leaderboard-tries'>" . $point["tries"] . " try" . "</div>" . "<br>";
            }
            else
            {
                echo "<div class='leaderboard-tries'>" . $point["tries"] . " tries" . "</div>" . "<br>";
            }
        }
        } else
        { // If there are no highscores to display in the leaderboard
            echo "No highscores yet! Be the first one by playing a match.";
        }
    }
?>
