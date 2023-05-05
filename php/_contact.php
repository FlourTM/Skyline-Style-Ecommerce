<?php
session_start();
// Grabs the SQL database from the database.php file
$mysqli = require __DIR__ . "/database.php";

if (isset($_POST["content"])) {
    $contactName = $_POST['name'];
    $contactEmail = $_POST['email'];
    $content = $_POST['content'];

    $stmt = $mysqli->prepare("INSERT INTO contact (contactName, contactEmail, content, contactDate) VALUES (?,?,?, NOW())");
    $stmt->bind_param("sss", $contactName, $contactEmail, $content);

    if (!$stmt->execute()) {
        echo ($stmt->affected_rows);
    }

    $stmt->close();
}
$mysqli->close();