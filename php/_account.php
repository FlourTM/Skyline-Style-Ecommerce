<?php
session_start();

// Signing up
if (isset($_POST['confirmpassword'])) {
    // Grabs the SQL database from the database.php file
    $mysqli = require __DIR__ . "/database.php";

    // Variables sent from JS
    $first = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $last = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'remail', FILTER_SANITIZE_EMAIL);
    $pass_hash = password_hash($_POST["rpassword"], PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ('Invalid email!');
        exit;
    }

    if (!preg_match("/^[a-zA-Z ]+$/", $first)) {
        echo ('Invalid first name!');
        exit;
    }

    if (!preg_match("/^[a-zA-Z ]+$/", $last)) {
        echo ('Invalid last name!');
        exit;
    }

    $sql = "INSERT INTO user (firstName, lastName, email, pass_hash)
    VALUES (?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $first, $last, $email, $pass_hash);

    if (!$stmt) {
        die("SQL error: " . $mysqli->error);
    }

    try {
        $stmt->execute();
        echo ("Registration successful!");
        $mysqli->close();
    } catch (Exception $e) {
        if ($e->getCode() == "1062") {
            echo ("Email already taken!");
        } else {
            die('Please try again later.');
        }
    }
}

//Logging in
if (isset($_POST['lemail'])) {
    // Information
    $email = filter_input(INPUT_POST, 'lemail', FILTER_SANITIZE_EMAIL);
    $mysqli = require __DIR__ . "/database.php";

    $maxLoginAttempts = 5;
    $maxAttemptTimer = 1; // Minutes

    // Implement rate limiting
    $attempts = isset($_SESSION['login_attempts']) ? (int) $_SESSION['login_attempts'] : 0;
    $lastAttemptTime = isset($_SESSION['login_attempt_time']) ? $_SESSION['login_attempt_time'] : null;

    // Clearing the rate limit 
    if ($lastAttemptTime && time() - $lastAttemptTime > $maxAttemptTimer * 60) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_attempt_time'] = null;
    }

    //  If they got rate limited
    if ($attempts >= $maxLoginAttempts) {
        echo 'Too many login attempts. Please try again later.';
        exit;
    }

    // Email validation to prevent attacks
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email or password!';
        exit;
    }

    // Sending to database
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["lpassword"], $user["pass_hash"])) {
            $_SESSION["userid"] = $user["id"];
            $_SESSION['login_attempts'] = 0; // Reset login attempts when login is successful
            $_SESSION['login_attempt_time'] = null; // Reset login attempt time as well
            echo 'login_succ';
        } else {
            $_SESSION['login_attempts'] = $attempts + 1; //Increment login atempts when login fails
            $_SESSION['login_attempt_time'] = time(); // Document last attempt time
            echo "Invalid email or password!";
        }
        $mysqli->close();
    } else {
        echo "No account associated with this email!";
    }
}

//Logging out
if (isset($_POST['logout'])) {
    if (session_status() === PHP_SESSION_ACTIVE) {
        unset($_SESSION['userid']);
        session_destroy();
    }
    exit;
}