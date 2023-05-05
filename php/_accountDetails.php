<?php
session_start();
// Grabs the SQL database from the database.php file
$mysqli = require __DIR__ . "/database.php";

// Checks if $_POST['name'] exists, if true, then we're updating the user's info
if (isset($_POST["fName"])) {
    $first = $_POST['fName'];
    $last = $_POST['lName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sesid = $_SESSION['userid'];

    $sqlfetch = "SELECT * FROM user";
    $stmt = $mysqli->prepare($sqlfetch);
    $stmt->execute();
    $result = $stmt->get_result();

    $emailTaken = false;
    $phoneTaken = false;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['email'] == $email && $row['id'] != $sesid) {
                $emailTaken = true;
                break;
            }
            if ($row['phone'] == $phone && $row['id'] != $sesid) {
                $phoneTaken = true;
                break;
            }
        }
    }

    if ($emailTaken) {
        echo ("Email already taken!");
    } elseif ($phoneTaken) {
        echo ("Phone already taken!");
    } else {
        $sql = "UPDATE user 
            SET firstName = ?, lastName = ?, email = ?, phone = ?
            WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssi", $first, $last, $email, $phone, $sesid);

        if ($stmt->execute()) {
            echo ("Account details successfully saved.");
        } else {
            echo ("Error: " . $stmt->error);
        }
    }
}

// if $_POST['password'] exists, then we're updating the user's password
if (isset($_POST["password"])) {
    $pass = $mysqli->real_escape_string(password_hash($_POST["newpass"], PASSWORD_DEFAULT));
    $sesid = $mysqli->real_escape_string($_SESSION['userid']);

    $sqlfetch = sprintf(
        "SELECT * FROM user WHERE id = '%s'",
        $mysqli->real_escape_string($_SESSION['userid'])
    );
    $result = $mysqli->query($sqlfetch);
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["pass_hash"])) {
            $sql = "UPDATE user 
                SET pass_hash = '$pass'
                WHERE id = '$sesid'";

            if (!$mysqli->query($sql)) {
                echo ($mysqli->affected_rows);
            }
            echo ("Password successfully changed!");
        } else {
            echo ("Current password incorrect!");
        }
    }
}

if (isset($_POST["newAddr"])) {
    $data = json_decode($_POST['newAddr'], true);
    $userId = $_SESSION['userid'];
  
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
  
    if ($user) {
        $stmt = $mysqli->prepare("INSERT INTO addresses (userID, firstName, lastName, company, address1, address2, city, stateName, stateAbbr, zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssss", $userId, $data['firstName'], $data['lastName'], $data['company'], $data['address1'], $data['address2'], $data['city'], $data['state'], $data['stateAbbr'], $data['zip']);
        
        $mysqli->begin_transaction();
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $mysqli->commit();
        
        if ($success) {
        echo "Address successfully saved!";
        } else {
        // Don't disclose sensitive information
        error_log("Failed to save address: " . $stmt->error);
        echo "Failed to save address. Please try again later.";
        }
    } else {
        // Don't disclose sensitive information
        error_log("User not found: " . $userId);
        echo "Failed to save address. Please try again later.";
    }
}

if (isset($_POST["addremove"])) {
    $id = $_POST['addremove'];
    $userID = $_SESSION['userid'];

    $stmt = $mysqli->prepare("DELETE FROM addresses WHERE userID = ? and id = ?");
    $stmt->bind_param("ii", $userID, $id);

    if (!$stmt->execute()) {
        echo ($stmt->affected_rows);
    }

    $stmt->close();
}

$mysqli->close();
