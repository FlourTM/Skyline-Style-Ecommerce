<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/output.css" rel="stylesheet">
    <link href="./css/input.css" rel="stylesheet">
    <link rel="icon" href="./assets/DMicon.png">
    <title>Cart</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script src="javascript/functions.js"></script>
    <script type="module" src="javascript/navbar.js"></script>
    <script type="module" src="javascript/cart.js"></script>

    <?php
    $user = false;
    if (isset($_SESSION['userid'])){
        $mysqli = require __DIR__ . "/php/database.php";
        $sql = sprintf(
            "SELECT * FROM user
                WHERE id = '%s'",
            $mysqli->real_escape_string($_SESSION['userid'])
        );
        $result = $mysqli->query($sql);
        $user = $result->fetch_assoc();
    }
    ?>

    <div id='Cart' class='w-full min-h-screen bg-LMbg dark:bg-DMbg '>

        <?php
        if ($user) {
            ?> <?php
            $mysqli = require __DIR__ . "/php/database.php";

            $cart = sprintf(
                "SELECT * FROM cart
                    WHERE userID = '%s'",
                $mysqli->real_escape_string($_SESSION['userid'])
            );

            $useritems = $mysqli->query($cart);
            if ($useritems) {
                if (mysqli_num_rows($useritems) > 0) {
                    include('php\cms.php');
                ?> <!-- Cart with items -->
                    <div class="fixed top-0 w-full h-screen overflow-x-hidden overflow-y-auto">
                        <div class="z-10 w-full h-full overflow-x-hidden transition duration-700 ease-in-out transform translate-x-0 lg:absolute lg:right-0">
                            <div class="flex flex-col items-end justify-end lg:flex-row">
                                <!-- Cart -->
                                <div class="w-full h-auto px-4 pt-20 pb-4 overflow-x-hidden md:w-3/4 -lg:mx-auto lg:w-2/3 xl:pl-52 lg:px-8 lg:h-screen">
                                    <h1 class="py-3 text-4xl font-bold leading-10 text-LMtext1 dark:text-DMtext1">Your Cart</h1>

                                    <?php
                                    $tbl = $GLOBALS['cmstbl'];
                                    while ($row = mysqli_fetch_assoc($useritems)) {     
                                        $info = $row['itemID'];
                                        ?>
                                            <!-- Individual Item -->
                                            <div id='details' itemID=<?=$info?><?php if($row["itemSize"]){?> itemSize=<?=$row['itemSize'];}?> 
                                            itemPrice=<?=$tbl[$info]["price"]?> class="items-stretch py-8 border-t sm:flex border-LMtext2 dark:border-DMtext2">
                                                <!-- Image -->
                                                <div class='w-1/4 sm:w-1/5 min-w-[140px] max-w-[200px] mx-auto'>
                                                    <a href="<?=$tbl[$info]["slug"]?>">
                                                        <img src="<?=$tbl[$info]["image"]["url"]?>" alt='image1' class='object-cover object-center w-full bg-white aspect-3/4' />
                                                    </a>
                                                </div>

                                                <div class="flex flex-col justify-center w-full sm:pl-3 text-LMtext1 dark:text-DMtext1">
                                                    <div>
                                                        <!-- Title and Quantity -->
                                                        <div class="flex items-center justify-between w-full gap-4">
                                                        <a href="<?=$tbl[$info]["slug"]?>" class="text-2xl font-semibold"><?=$tbl[$info]["name"]?></a>

                                                            <div class="flex items-center">
                                                                <p class='px-2 font-medium'>Quantity:</p>
                                                                <select class='border-b rounded cursor-pointer quantity bg-LMbg dark:bg-DMbg border-LMtext1 dark:border-DMtext1'>
                                                                    <option value="<?= $row["itemQuantity"] ?>" selected disabled hidden><?= $row["itemQuantity"] ?></option>
                                                                    <option value='1'>1</option>
                                                                    <option value='2'>2</option>
                                                                    <option value='3'>3</option>
                                                                    <option value='4'>4</option>
                                                                    <option value='5'>5</option>
                                                                    <option value='6'>6</option>
                                                                    <option value='7'>7</option>
                                                                    <option value='8'>8</option>
                                                                    <option value='9'>9</option>
                                                                    <option value='10'>10</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php if ($row['itemSize']) {
                                                                ?> <p class='pt-2 font-medium'>Size: <span class='font-normal'><?= $row["itemSize"] ?></span></p>
                                                        <?php } ?>
                                                    </div>

                                                    <!-- Buttons and Price -->
                                                    <div class="flex items-center justify-between pt-5">
                                                        <div class="flex items-center gap-4">
                                                            <button type="submit" class='px-2 text-sm border border-b-2 rounded addWishlist w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>
                                                                <?php
                                                                    $userID = $_SESSION['userid'];
                                                                    $itemID = $tbl[$info]["id"];
                                                                    $itemSize = $row['itemSize'];
                                                                    $grabData = "SELECT * FROM wishlist WHERE userID = $userID and itemID ='$itemID'";
                                                                    $result = $mysqli->query($grabData);
                                                                    $item = $result->fetch_assoc();
                                                                if($item){if($item['itemID']== $itemID){?>Remove from Wishlist<?php }}else{?>Add to Wishlist<?php }?>
                                                            </button>
                                                            <button type="submit" class='px-2 text-sm border border-b-2 rounded removeCart w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Remove</button>
                                                        </div>
                                                        <p id='price' class="font-semibold">$<?=$tbl[$info]["price"]?></p>
                                                    </div>
                                                    <p id="confirm-msg" class="text-sm text-red-600 confirm-message"></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                </div>

                                <!-- Order Summary -->
                                <div class="w-full h-full lg:w-96 bg-zinc-300 dark:bg-gray-800">
                                    <div class="flex flex-col justify-between h-auto px-4 py-6 mx-auto overflow-y-auto lg:h-screen lg:px-8 md:px-7 lg:py-20 md:py-10 md:w-3/4 lg:w-full">
                                        <div class="text-lg text-LMtext1 dark:text-DMtext1">
                                            <p class="py-3 text-4xl font-bold leading-10">Order Summary</p>
                                            <div class="flex items-center justify-between pt-8 border-t border-LMtext2 dark:border-DMtext2">
                                                <p class="font-semibold">Subtotal</p>
                                                <p id='subtotal'></p>
                                            </div>
                                            <div class="flex items-center justify-between pt-5">
                                                <p class="font-semibold">Shipping</p>
                                                <p id='shipping'></p>
                                            </div>
                                            <div class="flex items-center justify-between pt-5">
                                                <p class="font-semibold">Tax</p>
                                                <p id='tax'></p>
                                            </div>
                                        </div>
                                        <div class='place-items-center text-LMtext1 dark:text-DMtext1'>
                                            <div class="flex items-center justify-between pt-20 pb-4 lg:pt-5 ">
                                                <p class="text-2xl font-semibold">Total</p>
                                                <p id='total' class="text-2xl"></p>
                                            </div>

                                            <p class='font-medium text-center'>Accepted Payment Methods:</p>
                                            <img src='https://www.toddhannamddds.com/wp-content/uploads/2017/11/credit-card-visa-and-master-card-transparent-png.png' alt='Accepted Payment Methods' class='w-2/3 mx-auto'>

                                            <div class='flex flex-col pt-8 place-items-center'>
                                                <a href="checkout" type="submit" class='px-4 text-lg border border-b-4 rounded h-fit w-fit border-LMtext1 dark:border-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Proceed to Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                else { ?>
                <!-- Cart without items -->
                <div class='px-8 pt-24 lg:px-12 text-LMtext1 dark:text-DMtext1'>
                    <h1 class="text-4xl font-bold text-center">Your Cart</h1>
                    <p class='pt-6 pb-12 text-xl text-center text-LMtext2 dark:text-DMtext2'>There are no products in your cart.</p>

                    <p class='text-xl font-medium text-center'>Accepted Payment Methods:</p>
                    <img src='https://www.toddhannamddds.com/wp-content/uploads/2017/11/credit-card-visa-and-master-card-transparent-png.png' alt='Accepted Payment Methods' class='mx-auto w-52'>

                    <div class='grid justify-center max-w-full grid-cols-2 gap-5 py-12 mx-auto text-xl font-semibold text-center lg:flex md:gap-8 '>
                        <a href='women' class='lg:w-1/4'>
                            <img src='https://images.unsplash.com/photo-1558769132-cb1aea458c5e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80' alt='Shop Women' class='object-cover object-center sm:w-full aspect-square' />
                            <p class='pt-5'>Shop Women</p>
                        </a>

                        <a href='men' class='lg:w-1/4'>
                            <img src='https://images.unsplash.com/photo-1561053720-76cd73ff22c3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80' alt='Shop Men' class='object-cover object-center sm:w-full aspect-square' />
                            <p class='pt-5'>Shop Men</p>
                        </a>

                        <a href='jewelry' class='lg:w-1/4'>
                            <img src='https://images.unsplash.com/photo-1613843351058-1dd06fda7c02?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80' alt='Shop Jewelry' class='object-cover object-center sm:w-full aspect-square' />
                            <p class='pt-5'>Shop Jewelry</p>
                        </a>

                        <a href='bags' class='lg:w-1/4'>
                            <img src='https://images.pexels.com/photos/9218538/pexels-photo-9218538.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' alt='Shop Bags' class='object-cover object-center sm:w-full aspect-square' />
                            <p class='pt-5'>Shop Bags</p>
                        </a>
                    </div>
                </div>
                <?php }
            } ?>
            <?php
            $mysqli->close();
        } else {
        ?>
            <div class='px-8 pt-24 lg:px-12 text-LMtext1 dark:text-DMtext1'>
                <h1 class="text-4xl font-bold text-center">Your Cart</h1>
                <p class='pt-6 pb-12 text-xl text-center text-LMtext2 dark:text-DMtext2'>You must be signed in to view your cart.</p>
            </div><?php
        }
        ?>
    </div>
</body>

</html>