<?php
// Load database credentials from a configuration file
$config = parse_ini_file('config.ini');

// Create a new MySQLi object with the credentials from the configuration file
$mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

// Check for connection errors
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// Define a function to sanitize user input

if (!function_exists('sanitize_input')) {
    function sanitize_input($input)
    {
        global $mysqli;
        return mysqli_real_escape_string($mysqli, $input);
    }
}

if (!function_exists('validate_input')) {
    // Define a function to validate user input
    function validate_input($input)
    {
        // Use the htmlspecialchars() function to encode special characters in the input
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
return $mysqli;