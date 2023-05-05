<?php
require_once '../vendor/autoload.php';
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

CacheManager::setDefaultConfig(new ConfigurationOption([
    'path' => 'cache',
]));

// In your class, function, you can call the Cache
$InstanceCache = CacheManager::getInstance('files');

session_start();
// Grabs the SQL database from the database.php file
$mysqli = require __DIR__ . "/database.php";
$maxitems = 10;

//  Adding to wishlist database
if (isset($_POST["wlAdd"])) {
    $userID = $_SESSION['userid'];
    $itemID = $_POST['itemID'];

    $stmt = $mysqli->prepare("INSERT INTO wishlist (userID, itemID) VALUES ((SELECT id FROM user WHERE id = ?), ?)");
    $stmt->bind_param("is", $userID, $itemID);

    if (!$stmt->execute()) {
        echo ($stmt->affected_rows);
    }

    $stmt->close();
}

// Removing from wishlist database
if (isset($_POST["wlRemove"])) {
    $userID = $_SESSION['userid'];
    $itemID = $_POST['itemID'];

    $stmt = $mysqli->prepare("DELETE FROM wishlist WHERE userID = ? AND itemID = ?");
    $stmt->bind_param("is", $userID, $itemID);

    if (!$stmt->execute()) {
        echo ($stmt->affected_rows);
    }

    $stmt->close();
}

// Adding to cart database
if (isset($_POST["cartAdd"])) {
    $userID = $mysqli->real_escape_string($_SESSION['userid']);
    $itemID = $mysqli->real_escape_string($_POST['itemID']);
    $itemSize = "";
    $itemQuantity = $mysqli->real_escape_string($_POST['itemQuantity']);

    $grabData = "SELECT * FROM cart WHERE userID = $userID and itemID ='$itemID'";
    if (isset($_POST['itemSize'])) {
        $itemSize = $mysqli->real_escape_string($_POST['itemSize']);
        $grabData .= "AND itemSize = '$itemSize'";
    }

    $result = $mysqli->query($grabData);
    $returnedData = $result->fetch_assoc();

    // (SELECT id FROM user WHERE id = $userID)
    if (!$returnedData) {
        if (isset($itemSize)) {
            $sql = "INSERT INTO cart (userID, itemID, itemSize, itemQuantity)
                    VALUES ((SELECT id FROM user WHERE id = $userID), '$itemID', '$itemSize', '$itemQuantity')";
        } else {
            $sql = "INSERT INTO cart (userID, itemID, itemQuantity)
                    VALUES ((SELECT id FROM user WHERE id = $userID), '$itemID', '$itemQuantity')";
        }
        if (!$mysqli->query($sql)) {
            echo "Error: " . $mysqli->error;
        } else {
            echo "Successfully added to cart!";
        }
    } else {
        if (isset($_POST['updateCart'])) {
            if (isset($itemSize)) {
                $sql = "UPDATE cart SET itemQuantity = '$itemQuantity' 
                        WHERE userID = '$userID' AND itemID = '$itemID' AND itemSize = '$itemSize'";
            } else {
                $sql = "UPDATE cart SET itemQuantity = '$itemQuantity' 
                        WHERE userID = '$userID' AND itemID = '$itemID'";
            }
            if (!$mysqli->query($sql)) {
                echo "Error: " . $mysqli->error;
            }
        } else {
            $itemQuantityInCart = $returnedData['itemQuantity'];
            if ($itemQuantityInCart < $maxitems) {
                $newItemQuantity = $itemQuantityInCart + 1;
                if (isset($itemSize)) {
                    $sql = "UPDATE cart SET itemQuantity = '$newItemQuantity' 
                            WHERE userID = '$userID' AND itemID = '$itemID' AND itemSize = '$itemSize'";
                } else {
                    $sql = "UPDATE cart SET itemQuantity = '$newItemQuantity' 
                            WHERE userID = '$userID' AND itemID = '$itemID'";
                }
                if (!$mysqli->query($sql)) {
                    echo "Error: " . $mysqli->error;
                } else {
                    echo "Successfully added to cart!";
                }
            } else {
                echo "Max amount of items reached!";
            }
        }
    }
}

// Removing from cart database
if (isset($_POST["cartRemove"])) {
    $userID = $_SESSION['userid'];
    $itemID = $_POST['itemID'];
    $itemSize = $_POST['itemSize'];
    $itemQuantity = $_POST['itemQuantity'];

    // Validate input
    if (!is_numeric($itemQuantity)) {
        exit("Invalid input");
    }

    // Updating Items
    if ($itemSize != 'null') {
        $stmt = $mysqli->prepare("UPDATE cart SET itemQuantity = ? WHERE userID = ? and itemID = ? and itemSize = ?");
        $stmt->bind_param("iiis", $itemQuantity, $userID, $itemID, $itemSize);
    } else {
        $stmt = $mysqli->prepare("UPDATE cart SET itemQuantity = ? WHERE userID = ? and itemID = ?");
        $stmt->bind_param("iii", $itemQuantity, $userID, $itemID);
    }

    // Execute statement
    if ($stmt->execute()) {
        echo "Cart updated successfully";
    } else {
        echo "Error updating cart";
    }

    $stmt->close();

    // Removing Items
    if ($itemQuantity == 0) {
        if ($itemSize != 'null') {
            $sql = "DELETE FROM cart WHERE userID = ? and itemID = ? and itemSize = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $userID, $itemID, $itemSize);
            $stmt->execute();
            $stmt->close();
        } else {
            $sql = "DELETE FROM cart WHERE userID = ? and itemID = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $userID, $itemID);
            $stmt->execute();
            $stmt->close();
        }
    }
}


// Trello Promo Code Handler
$key = "promocodes";
$CachedString = $InstanceCache->getItem($key);
if (isset($_POST['promo']) && !empty($_POST['promo'])) {
    if (!$CachedString->isHit()) {
        $listID = '641cab7f4aa7062b24b634dd';
        $key = 'd978a3647a3d1b4dec17cb8dde9d71ef';
        $token = 'ATTA9b86160b2bfb6700e47d0cc07dddf4527a5b285a82b8fd32d5e0aeda9268b70a456E3B82';
        $url = "https://api.trello.com/1/lists/{$listID}/cards?key={$key}&token={$token}";

        $c = curl_init();
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_VERBOSE, 0);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_HTTPGET, 1);

        $result = curl_exec($c);
        $data = json_decode($result);
        curl_close($c);

        // Store promocodes in cache
        $CachedString->set($data)->expiresAfter(3600); //in seconds, also accepts Datetime
        $InstanceCache->save($CachedString); // Save the cache item just like you do with doctrine and entities
    } else {
        $data = $CachedString -> get();
    }

    $input = filter_input(INPUT_POST, 'promo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    function check($data, $input)
    {
        for ($i = 0; $i < count($data); $i++) {
            if (strtoupper(strval($input)) == strtoupper(strval($data[$i]->name))) {
                return $data[$i]->desc;
            }
        }
        return false;
    }

    try {
        $retrieved = check($data, $input);
        if ($retrieved) {
            echo ($retrieved);
        } else {
            echo (0);
        }
    } catch (Exception $e) {
        echo ("Something went wrong.");
    }
}

// Adding to Orders database and removing from Cart database
if (isset($_POST["orderConfirm"])) {
    $userID = $_SESSION['userid'];
    $data = json_decode($_POST['orderData'], true);

    // Use prepared statements to prevent SQL injection attacks
    $stmt = $mysqli->prepare("INSERT INTO orders (userID, `date`, shipMethod, promoCode, promoDiscount, subtotal, shipCost, tax, total)
        VALUES ((SELECT id FROM user WHERE id = $userID), NOW(), ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssddddd", $data['method'], $data['promo'], $data['discount'], $data['sub'], $data['shipCost'], $data['tax'], $data['total']);

    $result = $stmt->execute();

    if ($result) {
        $orderID = $mysqli->insert_id;
        echo ($orderID);
    }

    $stmt->close();

    // Use prepared statements to prevent SQL injection attacks
    $stmt2 = $mysqli->prepare("DELETE FROM cart WHERE userID = ?");

    // Bind parameters to the prepared statement
    $stmt2->bind_param("i", $userID);

    $result2 = $stmt2->execute();

    if (!$result2) {
        echo ($mysqli->affected_rows);
    }

    $stmt2->close();
}