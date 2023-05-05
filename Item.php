<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/output.css" rel="stylesheet">
    <link rel="icon" href="./assets/DMicon.png">
    <title>Item</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script src="javascript/functions.js"></script>
    <script type="module" src="javascript/navbar.js"></script>

    <?php
    session_start();

    //  CMS Stuff
    include('php\cms.php');
    $id = $_GET['slug'];
    $global = $GLOBALS['cmstbl'];
    $slugs = array_column($global, 'slug');
    $num;
    $tbl = false;
    $productID;

    if (array_search($id, $slugs) !== false) {
        $num = array_search($id, $slugs);
        $tbl = array_values($global)[$num];
        $productID = $tbl['id'];
    }

    // Database Stuff
    $userid;
    $usersql;
    $userresult;
    $item = false;

    $mysqli = require __DIR__ . "/php/database.php";

    if (isset($_SESSION['userid']) && isset($productID)) {
        $userid = $_SESSION['userid'];
        $usersql = "SELECT * FROM wishlist WHERE userID = $userid and itemID ='$productID'";
        $userresult = $mysqli->query($usersql);
        $item = $userresult->fetch_assoc();
    }

    ?>
    <?php if($tbl){ ?>
    <div name="Item" class='flex flex-col justify-between w-full min-h-screen bg-LMbg dark:bg-DMbg'>
        <div class='items-start justify-center px-12 pt-24 pb-12 lg:flex'>
            <!-- Image -->
            <img src=<?= $tbl["image"]["url"] ?> alt='image1'
                class='object-cover object-center w-3/4 max-w-3xl mx-auto bg-white lg:w-1/3 aspect-3/4' />
            <!-- Item Details -->
            <div id=<?= $tbl["id"] ?>
                class='grid gap-5 pt-8 m-auto itemdetails text-LMtext1 dark:text-DMtext1 lg:w-1/2 lg:pt-0'>
                <h3 class='text-3xl font-medium sm:text-4xl'><?= $tbl["name"] ?></h3>
                <p class='text-xl text-left sm:text-3xl'>$<?= $tbl["price"] ?></p>

                <?php
                if ($tbl["sizing"]) {
                    if (strtolower($tbl["subsection"]) == "shoes") { ?>
                        <!-- Shoe Sizing -->
                        <div class='px-2 border border-b-4 rounded border-LMtext1 dark:border-DMtext1 w-fit'>
                            <label class='text-lg'>Size:</label>
                            <select class='ml-5 sizeMenu bg-LMbg dark:bg-DMbg'>
                                <option value="" selected disabled hidden></option>
                                <option value='6'>6</option>
                                <option value='7'>7</option>
                                <option value='8'>8</option>
                                <option value='9'>9</option>
                                <option value='10'>10</option>
                                <option value='11'>11</option>
                                <option value='12'>12</option>
                            </select>
                        </div>
                    <?php } elseif (strtolower($tbl['section']) == 'jewelry' & $tbl['sizing']) { ?>
                        <!-- Ring Sizing -->
                        <div class='px-2 border border-b-4 rounded border-LMtext1 dark:border-DMtext1 w-fit'>
                            <label class='text-lg'>Size:</label>
                            <select class='ml-5 sizeMenu bg-LMbg dark:bg-DMbg'>
                                <option value="" selected disabled hidden></option>
                                <option value='5'>5</option>
                                <option value='6'>6</option>
                                <option value='7'>7</option>
                                <option value='8'>8</option>
                                <option value='9'>9</option>
                                <option value='10'>10</option>
                                <option value='11'>11</option>
                                <option value='12'>12</option>
                                <option value='13'>13</option>
                            </select>
                        </div>
                    <?php } else { ?>
                        <!-- Clothes Sizing -->
                        <div class='px-2 border border-b-4 rounded border-LMtext1 dark:border-DMtext1 w-fit'>
                            <label class='text-lg'>Size:</label>
                            <select class='ml-5 sizeMenu bg-LMbg dark:bg-DMbg'>
                                <option value="" selected disabled hidden></option>
                                <option value='XXSmall'>XX-Small</option>
                                <option value='XSmall'>X-Small</option>
                                <option value='Small'>Small</option>
                                <option value='Medium'>Medium</option>
                                <option value='Large'>Large</option>
                                <option value='XLarge'>X-Large</option>
                                <option value='XXLarge'>2X-Large</option>
                                <option value='3XLarge'>3X-Large</option>
                            </select>
                        </div>
                    <?php }
                    ;
                }
                ; ?>

                <!-- Buttons -->
                <div class='flex gap-5 lg:grid'>
                    <button type="submit" id='addCart' class='text-lg border border-b-4 rounded add w-36 sm:w-52 border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Add to
                        Cart</button>
                    <button type="submit" id='addWishlist' class='text-lg border border-b-4 rounded add w-36 sm:w-52 border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'><?php if ($item) { ?>Remove from
                            Wishlist<?php
                        } else {
                            ?>Add to
                            Wishlist<?php } ?></button>
                </div>

                <p id="confirm-msg" class="text-lg text-red-600 confirm-message"></p>

                <p class='sm:text-lg'>Enjoy <span class='font-bold'>free shipping</span> on all orders over $65</p>

                <div class='border-t-2 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->
                <!-- Description -->
                <h2 class='text-xl font-medium sm:text-2xl'>Description</h2>
                <p><?= $tbl["desc"] ?></p>
                <div class='border-t-2 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->
            </div>
        </div>
    </div>

    <script type="module" src="javascript/item.js"></script>

    <!-- Footer -->
    <my-header id=footer-ph w3-include-html='footer.html'></my-header>
    <script type="module" src="javascript/footer.js"></script>
</body>
<?php } else{
    echo('<script> window.location = "index" </script>');
}?>

</html>