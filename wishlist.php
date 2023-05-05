<?php session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/output.css" rel="stylesheet">
    <link href="./css/input.css" rel="stylesheet">
    <link rel="icon" href="./assets/DMicon.png">
    <title>Wishlist</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script type="module" src="javascript/navbar.js"></script>

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

    <div name="Wishlist" class='flex flex-col justify-between w-full min-h-screen bg-LMbg dark:bg-DMbg'>
        <div class='px-8 pt-24 lg:px-12'>
            <!-- Header -->
            <h1 class='text-4xl font-bold text-center text-LMtext1 dark:text-DMtext1'>Wishlist</h1>
            <p class='pt-6 pb-12 text-xl font-semibold text-center text-LMtext2 dark:text-DMtext2'>Pieces picked by you
            </p>

            <?php
            if ($user) {
                ?> <?php
                $mysqli = require __DIR__ . "/php/database.php";

                $wishlist = sprintf(
                    "SELECT * FROM wishlist
                        WHERE userID = '%s'",
                    $mysqli->real_escape_string($_SESSION['userid'])
                );

                $useritems = $mysqli->query($wishlist);

                if ($useritems) {
                    if (mysqli_num_rows($useritems) > 0) {
                        include('php\cms.php');
                        ?> <!-- IF PRODUCTS ARE ON WISHLIST -->
                        <div id='wishlistProducts'
                            class='grid items-start grid-cols-2 gap-10 px-5 py-16 text-LMtext1 dark:text-DMtext1 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 place-items-center'>
                            <?php
                            $tbl = $GLOBALS['cmstbl'];
                            while ($row = mysqli_fetch_assoc($useritems)) {     
                                $info = $row['itemID'];
                                ?>
                                    <a href="<?=$tbl[$info]["slug"]?>" class='w-full text-lg text-left lg:text-xl'>
                                        <img src="<?=$tbl[$info]["image"]["url"]?>" class='object-cover object-center w-full bg-white aspect-3/4'>
                                        <h2 class='font-medium'><?=$tbl[$info]["name"]?></h2>
                                        <p>$<?=$tbl[$info]["price"]?></p>
                                    </a>
                            <?php } ?>
                        </div>
                    <?php } 
                    else { ?> 
                        <!-- IF NO PRODUCTS ON WISHLIST -->
                        <div class="text-LMtext1 dark:text-DMtext1">
                            <p class='pt-6 pb-12 text-xl text-center text-LMtext2 dark:text-DMtext2'>There are no products on your
                                wishlist.</p>
    
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
                <p class='pt-6 pb-12 text-xl text-center text-LMtext2 dark:text-DMtext2'>You must be signed in to view your wishlist.</p>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <my-header id=footer-ph w3-include-html='footer.html'></my-header>
    <script type="module" src="javascript/footer.js"></script>
</body>

</html>