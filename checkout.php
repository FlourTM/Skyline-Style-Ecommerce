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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Checkout</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script src="javascript/functions.js"></script>
    <script type="module" src="javascript/navbar.js"></script>
    <script type="module" src="javascript/checkout.js"></script>

    <?php
    $mysqli = require __DIR__ . "/php/database.php";
    $usersql = sprintf(
        "SELECT * FROM user
            WHERE id = '%s'",
        $mysqli->real_escape_string($_SESSION['userid'])
    );
    $userresult = $mysqli->query($usersql);
    $user = $userresult->fetch_assoc();

    $addrsql = sprintf(
        "SELECT * FROM addresses
            WHERE userID = '%s'",
        $mysqli->real_escape_string($_SESSION['userid'])
    );
    $addresses = $mysqli->query($addrsql);

    ?>

    <div name="Checkout" class='flex flex-col justify-between w-full min-h-screen bg-LMbg dark:bg-DMbg'>
        <div class='px-8 pt-24 pb-8 lg:px-24'>
            <h1 class='pb-12 text-4xl font-bold text-center text-LMtext1 dark:text-DMtext1'>Checkout</h1>

            <div class='grid items-start gap-8 mx-auto md:flex max-w-7xl'>
                <!-- Shipping and Payment -->
                <div class='w-full md:w-2/3 text-LMtext1 dark:text-DMtext1'>
                    <div> <!-- Shipping Address and Method -->
                        <div id='addresses'>
                            <!-- Shipping Address -->
                            <h2 class='pb-2 text-2xl font-semibold'>Shipping Address</h2>
                            <div class='w-full pt-5 mx-auto border-t-4 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->
                                <?php 
                                if ($addresses) {
                                    if (mysqli_num_rows($addresses) > 0) { 
                                        ?>
                                        <!-- Current Addresses on File -->
                                        <div class='grid grid-cols-2 gap-4 text-sm lg:grid-cols-3 text-LMtext-2 dark:text-DMtext2'>
                                            <?php 
                                            while ($row = mysqli_fetch_assoc($addresses)) { ?> 
                                                <div>
                                                    <input id=<?=$row['id'] ?> type="radio" value=<?=$row['id'] ?> name='sAddrSelection' class="hidden peer">
                                                    <div class='h-full border rounded availableShips border-LMtext1 dark:border-DMtext1 hover:border-2 hover:border-accentBlue peer-checked:border-accentPink peer-checked:border-4'>
                                                        <label for=<?=$row['id'] ?> class='grid w-full p-2 my-auto text-sm cursor-pointer'>   
                                                            <p class="font-semibold text-LMtext1 dark:text-DMtext1"><?=$row["firstName"] ?> <?=$row["lastName"] ?></p>
                                                            <p><?=$row["company"] ?></p>
                                                            <p><?=$row["address1"] ?>, </p>
                                                            <?php if ($row['address2']) {
                                                            ?> <p><?=$row["address2"] ?>, </p>
                                                            <?php } ?>                                            
                                                            <p><?=$row["city"] ?>, <?=$row["stateAbbr"] ?> <?=$row["zip"] ?></p>
                                                        </label>
                                                    </div>
                                                </div> <?php
                                            } ?>
                                        </div> 
                                        <form id="sAddressForm" class="hidden pt-5 add text-LMtext2 dark:text-DMtext2">
                                            <div class='grid grid-flow-col gap-4'> <!-- Names -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>First Name</p>
                                                    <input id="sFirstName" name="sFirstName" type='text' placeholder='First Name' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Last Name</p>
                                                    <input id="sLastName" name="sLastName" type='text' placeholder='Last Name' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='py-5'> <!-- Company -->
                                                <p class='pb-1 text-lg font-semibold'>Company (Optional)</p>
                                                <input id="sCompany" name="sCompany" type='text' placeholder='Company' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                            </div>
                                            <div class='grid gap-4 pb-5 md:grid-flow-col'> <!-- Street Address -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 1</p>
                                                    <input id="sAddress1" name="sAddress1" type='text' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 2 (Optional)</p>
                                                    <input id="sAddress2" name="sAddress2" type='text' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='grid grid-flow-col gap-4 pb-1'> <!-- City, State, Zip -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>City</p>
                                                    <input id="sCity" name="sCity" type='text' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>State</p>
                                                    <select id='sState' name="sState" class="w-full text-lg bg-transparent border rounded input1 h-7 bg-LMbg dark:bg-DMbg border-LMtext1 dark:border-DMtext1">
                                                        <option value="" selected disabled hidden></option>
                                                        <option value="AL">Alabama</option>
                                                        <option value="AK">Alaska</option>
                                                        <option value="AZ">Arizona</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="CA">California</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="DC">District Of Columbia</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="HI">Hawaii</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WA">Washington</option>
                                                        <option value="WV">West Virginia</option>
                                                        <option value="WI">Wisconsin</option>
                                                        <option value="WY">Wyoming</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Zip Code</p>
                                                    <input id="sZip" name="sZip" type='text' onkeypress="return /^\d|-$/i.test(event.key)" maxlength="10" class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                    <p id="sZipMsg" class="pb-2 text-sm text-center text-red-600"></p>
                                                </div>
                                            </div>
                                            <input type="checkbox" id="sSaveAddr" name="sSaveAddr" value="sSaveAddr">
                                            <label for="sSaveAddr" class='pb-5 text-lg'> Save address to account</label><br>
                                        </form>

                                        <p id="confirm-msg1" class="py-2 text-lg text-center text-red-600"></p>
                                        <div class='flex justify-center pb-5'>
                                            <button id="sAddressBtn" type="button" class='px-8 text-lg border border-b-4 rounded add w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Add New Address</button>
                                        </div>  
                                        <?php
                                    $stmt = mysqli_data_seek($addresses,0); 
                                    } else { ?> 
                                        <form id="sAddressForm" class="pt-5 add text-LMtext2 dark:text-DMtext2">
                                            <div class='grid grid-flow-col gap-4'> <!-- Names -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>First Name</p>
                                                    <input id="sFirstName" name="sFirstName" type='text' placeholder='First Name' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Last Name</p>
                                                    <input id="sLastName" name="sLastName" type='text' placeholder='Last Name' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='py-5'> <!-- Company -->
                                                <p class='pb-1 text-lg font-semibold'>Company (Optional)</p>
                                                <input id="sCompany" name="sCompany" type='text' placeholder='Company' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                            </div>
                                            <div class='grid gap-4 pb-5 md:grid-flow-col'> <!-- Street Address -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 1</p>
                                                    <input id="sAddress1" name="sAddress1" type='text' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 2 (Optional)</p>
                                                    <input id="sAddress2" name="sAddress2" type='text' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='grid grid-flow-col gap-4 pb-1'> <!-- City, State, Zip -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>City</p>
                                                    <input id="sCity" name="sCity" type='text' class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>State</p>
                                                    <select id='sState' name="sState" class="w-full text-lg bg-transparent border rounded input1 h-7 bg-LMbg dark:bg-DMbg border-LMtext1 dark:border-DMtext1">
                                                        <option value="" selected disabled hidden></option>
                                                        <option value="AL">Alabama</option>
                                                        <option value="AK">Alaska</option>
                                                        <option value="AZ">Arizona</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="CA">California</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="DC">District Of Columbia</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="HI">Hawaii</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WA">Washington</option>
                                                        <option value="WV">West Virginia</option>
                                                        <option value="WI">Wisconsin</option>
                                                        <option value="WY">Wyoming</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Zip Code</p>
                                                    <input id="sZip" name="sZip" type='text' onkeypress="return /^\d|-$/i.test(event.key)" maxlength="10" class='w-full px-2 text-lg bg-transparent border rounded input1 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                    <p id="sZipMsg" class="pb-2 text-sm text-center text-red-600"></p>
                                                </div>
                                            </div>
                                            <input type="checkbox" id="sSaveAddr" name="sSaveAddr" value="sSaveAddr">
                                            <label for="sSaveAddr" class='pb-5 text-lg'> Save address to account</label><br>
                                        </form>

                                        <p id="confirm-msg1" class="py-2 text-lg text-center text-red-600"></p>
                                        <div class='flex justify-center pb-5'>
                                            <button id="sAddressBtn" type="button" class='px-8 text-lg border border-b-4 rounded save w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Use this address</button>
                                        </div>
                                    <?php 
                                    } ?> <?php
                                } ?>

                            <!-- Shipping Method -->
                            <h2 class='py-2 text-2xl font-semibold'>Delivery Options</h2>
                            <div class='w-full pt-5 mx-auto border-t-4 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->
                            <!-- If order is above $65, standard will have to be free -->
                            <div> <!-- Shipping Method Buttons -->
                                <div>
                                    <input id="standard" type="radio" value="standard" name='methodBtn' class='hidden peer'>
                                    <label for='standard' class='flex justify-between w-full px-8 py-2 text-lg border rounded cursor-pointer border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:border-2 hover:border-accentBlue peer-checked:border-accentPink peer-checked:border-4'>
                                        <p>Standard</p>
                                        <p id = "standardVal"></p>
                                    </label>
                                </div>
                                <div class='pt-3'>
                                    <input id="express" type="radio" value="express" name='methodBtn' class='hidden peer'>
                                    <label for='express' class='flex justify-between w-full px-8 py-2 text-lg border rounded cursor-pointer border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:border-2 hover:border-accentBlue peer-checked:border-accentPink peer-checked:border-4'>
                                        <p>Express 3-Day</p>
                                        <p>$9.99</p>
                                    </label>
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <h2 class='pt-8 pb-2 text-2xl font-semibold'>Billing Address</h2>
                            <div class='w-full pt-5 mx-auto border-t-4 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->

                            <?php 
                                if ($addresses) {
                                    if (mysqli_num_rows($addresses) > 0) {
                                        ?>
                                        <!-- Current Addresses on File -->
                                        <div class='grid grid-cols-2 gap-4 text-sm lg:grid-cols-3 text-LMtext-2 dark:text-DMtext2'>
                                            <?php 
                                            while ($row = mysqli_fetch_assoc($addresses)) { 
                                                ?> 
                                                <div>
                                                    <input id=b<?=$row['id'] ?> type="radio" value=<?=$row['id']?> name='bAddrSelection' class="hidden peer">
                                                    <div class='h-full border rounded availableBills border-LMtext1 dark:border-DMtext1 hover:border-2 hover:border-accentBlue peer-checked:border-accentPink peer-checked:border-4'>
                                                        <label for=b<?=$row['id'] ?> class='grid w-full p-2 my-auto text-sm cursor-pointer'>
                                                            <p class="font-semibold text-LMtext1 dark:text-DMtext1"><?=$row["firstName"] ?> <?=$row["lastName"] ?></p>
                                                            <p><?=$row["company"] ?></p>
                                                            <p><?=$row["address1"] ?>, </p>
                                                            <?php if ($row['address2']) {
                                                            ?> <p><?=$row["address2"] ?>, </p>
                                                            <?php } ?>                                            
                                                            <p><?=$row["city"] ?>, <?=$row["stateAbbr"] ?> <?=$row["zip"] ?></p>
                                                        </label>
                                                    </div>
                                                </div> <?php
                                            } ?>
                                        </div> 
                                        <form id="bAddressForm" class="hidden pt-5 add text-LMtext2 dark:text-DMtext2">
                                            <div class='grid grid-flow-col gap-4'> <!-- Names -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>First Name</p>
                                                    <input id="bFirstName" name="bFirstName" type='text' placeholder='First Name' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Last Name</p>
                                                    <input id="bLastName" name="bLastName" type='text' placeholder='Last Name' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='py-5'> <!-- Company -->
                                                <p class='pb-1 text-lg font-semibold'>Company (Optional)</p>
                                                <input id="bCompany" name="bCompany" type='text' placeholder='Company' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                            </div>
                                            <div class='grid gap-4 pb-5 md:grid-flow-col'> <!-- Street Address -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 1</p>
                                                    <input id="bAddress1" name="bAddress1" type='text' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 2 (Optional)</p>
                                                    <input id="bAddress2" name="bAddress2" type='text' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='grid grid-flow-col gap-4 pb-1'> <!-- City, State, Zip -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>City</p>
                                                    <input id="bCity" name="bCity" type='text' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>State</p>
                                                    <select id='bState' name="bState" class="w-full text-lg bg-transparent border rounded input2 h-7 bg-LMbg dark:bg-DMbg border-LMtext1 dark:border-DMtext1">
                                                        <option value="" selected disabled hidden></option>
                                                        <option value="AL">Alabama</option>
                                                        <option value="AK">Alaska</option>
                                                        <option value="AZ">Arizona</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="CA">California</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="DC">District Of Columbia</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="HI">Hawaii</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WA">Washington</option>
                                                        <option value="WV">West Virginia</option>
                                                        <option value="WI">Wisconsin</option>
                                                        <option value="WY">Wyoming</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Zip Code</p>
                                                    <input id="bZip" name="bZip" type='text' onkeypress="return /^\d|-$/i.test(event.key)" maxlength="10" class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                    <p id="bZipMsg" class="pb-2 text-sm text-center text-red-600"></p>
                                                </div>
                                            </div>
                                        </form>

                                        <p id="confirm-msg2" class="py-2 text-lg text-center text-red-600"></p>
                                        <div class='flex justify-center pb-5'>
                                            <button id="bAddressBtn" type="button" class='px-8 text-lg border border-b-4 rounded add w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Add New Address</button>
                                        </div>  
                                        <?php
                                    } else { ?> 
                                        <form id="bAddressForm" class="pt-5 add text-LMtext2 dark:text-DMtext2">
                                            <div class='grid grid-flow-col gap-4'> <!-- Names -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>First Name</p>
                                                    <input id="bFirstName" name="bFirstName" type='text' placeholder='First Name' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Last Name</p>
                                                    <input id="bLastName" name="bLastName" type='text' placeholder='Last Name' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='py-5'> <!-- Company -->
                                                <p class='pb-1 text-lg font-semibold'>Company (Optional)</p>
                                                <input id="bCompany" name="bCompany" type='text' placeholder='Company' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                            </div>
                                            <div class='grid gap-4 pb-5 md:grid-flow-col'> <!-- Street Address -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 1</p>
                                                    <input id="bAddress1" name="bAddress1" type='text' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Address 2 (Optional)</p>
                                                    <input id="bAddress2" name="bAddress2" type='text' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                            </div>
                                            <div class='grid grid-flow-col gap-4 pb-1'> <!-- City, State, Zip -->
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>City</p>
                                                    <input id="bCity" name="bCity" type='text' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>State</p>
                                                    <select id='bState' name="bState" class="w-full text-lg bg-transparent border rounded input2 h-7 bg-LMbg dark:bg-DMbg border-LMtext1 dark:border-DMtext1">
                                                        <option value="" selected disabled hidden></option>
                                                        <option value="AL">Alabama</option>
                                                        <option value="AK">Alaska</option>
                                                        <option value="AZ">Arizona</option>
                                                        <option value="AR">Arkansas</option>
                                                        <option value="CA">California</option>
                                                        <option value="CO">Colorado</option>
                                                        <option value="CT">Connecticut</option>
                                                        <option value="DE">Delaware</option>
                                                        <option value="DC">District Of Columbia</option>
                                                        <option value="FL">Florida</option>
                                                        <option value="GA">Georgia</option>
                                                        <option value="HI">Hawaii</option>
                                                        <option value="ID">Idaho</option>
                                                        <option value="IL">Illinois</option>
                                                        <option value="IN">Indiana</option>
                                                        <option value="IA">Iowa</option>
                                                        <option value="KS">Kansas</option>
                                                        <option value="KY">Kentucky</option>
                                                        <option value="LA">Louisiana</option>
                                                        <option value="ME">Maine</option>
                                                        <option value="MD">Maryland</option>
                                                        <option value="MA">Massachusetts</option>
                                                        <option value="MI">Michigan</option>
                                                        <option value="MN">Minnesota</option>
                                                        <option value="MS">Mississippi</option>
                                                        <option value="MO">Missouri</option>
                                                        <option value="MT">Montana</option>
                                                        <option value="NE">Nebraska</option>
                                                        <option value="NV">Nevada</option>
                                                        <option value="NH">New Hampshire</option>
                                                        <option value="NJ">New Jersey</option>
                                                        <option value="NM">New Mexico</option>
                                                        <option value="NY">New York</option>
                                                        <option value="NC">North Carolina</option>
                                                        <option value="ND">North Dakota</option>
                                                        <option value="OH">Ohio</option>
                                                        <option value="OK">Oklahoma</option>
                                                        <option value="OR">Oregon</option>
                                                        <option value="PA">Pennsylvania</option>
                                                        <option value="RI">Rhode Island</option>
                                                        <option value="SC">South Carolina</option>
                                                        <option value="SD">South Dakota</option>
                                                        <option value="TN">Tennessee</option>
                                                        <option value="TX">Texas</option>
                                                        <option value="UT">Utah</option>
                                                        <option value="VT">Vermont</option>
                                                        <option value="VA">Virginia</option>
                                                        <option value="WA">Washington</option>
                                                        <option value="WV">West Virginia</option>
                                                        <option value="WI">Wisconsin</option>
                                                        <option value="WY">Wyoming</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <p class='pb-1 text-lg font-semibold'>Zip Code</p>
                                                    <input id="bZip" name="bZip" type='text' onkeypress="return /^\d|-$/i.test(event.key)" maxlength="10" class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                                    <p id="bZipMsg" class="pb-2 text-sm text-center text-red-600"></p>
                                                </div>
                                            </div>
                                        </form>

                                        <p id="confirm-msg2" class="py-2 text-lg text-center text-red-600"></p>
                                        <div class='flex justify-center pb-5'>
                                            <button id="bAddressBtn" type="button" class='px-8 text-lg border border-b-4 rounded save w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Use this address</button>
                                        </div>
                                    <?php } ?> <?php
                                } ?>
                        </div>
                    </div>

                    <div id='payment' class='hidden w-1/2'> <!-- Payment Method -->
                        <div class='pb-4'> <!-- Continue Button -->
                            <button id='goBack' type="button" class='px-16 text-lg border border-b-4 rounded goBack h-fit w-fit border-LMtext1 dark:border-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Go Back</button>
                        </div>

                        <h2 class='pb-2 text-2xl font-semibold'>Payment Information</h2>
                        <div class='w-full pt-5 mx-auto border-t-4 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->
                        <div id="card-number"> <!-- Card Number -->
                            <p class='pb-1 text-lg font-semibold'>Card Number</p>
                            <input id="ccNumber" name="ccNumber" type="text" onkeypress="return /[0-9]/i.test(event.key)" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" class='w-full px-2 text-lg bg-transparent border rounded input3 h-7 border-LMtext2 dark:border-DMtext2'></input>
                        </div>
                        <div class='grid grid-flow-col gap-4'> <!-- Exp. Date & Security Card -->
                            <div> <!-- Exp. Date -->
                                <p class='pb-1 text-lg font-semibold'>Expiration Date</p>
                                <div class='flex gap-2'>
                                    <select name='expireMM' id='expireMM' class='px-2 text-lg bg-transparent border rounded input3 h-7 w-fit border-LMtext2 dark:border-DMtext2 bg-LMbg dark:bg-DMbg'>
                                        <option value='' selected disabled hidden>MM</option>
                                        <option value='01'>01</option>
                                        <option value='02'>02</option>
                                        <option value='03'>03</option>
                                        <option value='04'>04</option>
                                        <option value='05'>05</option>
                                        <option value='06'>06</option>
                                        <option value='07'>07</option>
                                        <option value='08'>08</option>
                                        <option value='09'>09</option>
                                        <option value='10'>10</option>
                                        <option value='11'>11</option>
                                        <option value='12'>12</option>
                                    </select>
                                    <select name='expireYY' id='expireYY' class='px-2 text-lg bg-transparent border rounded input3 h-7 w-fit border-LMtext2 dark:border-DMtext2 bg-LMbg dark:bg-DMbg'>
                                        <option value='' selected disabled hidden>YYYY</option>
                                        <option value='23'>2023</option>
                                        <option value='24'>2024</option>
                                        <option value='25'>2025</option>
                                        <option value='26'>2026</option>
                                        <option value='27'>2027</option>
                                        <option value='28'>2028</option>
                                        <option value='29'>2029</option>
                                        <option value='30'>2030</option>
                                        <option value='31'>2031</option>
                                        <option value='32'>2032</option>
                                    </select>
                                </div>
                            </div>
                            <form> <!-- Security Code -->
                                <p class='pb-1 text-lg font-semibold whitespace-nowrap'>CVV</p>
                                <input id="secCode" name="secCode" type='password' onkeypress="return /[0-9]/i.test(event.key)" maxlength="3" class='w-full px-2 text-lg bg-transparent border rounded input3 h-7 border-LMtext2 dark:border-DMtext2'></input>
                            </form>
                        </div>
                        <div> <!-- Name on Card -->
                            <p class='pb-1 text-lg font-semibold'>Name on Card</p>
                            <input id="cardName" name="cardName" type='text' class='w-full px-2 text-lg bg-transparent border rounded input3 h-7 border-LMtext2 dark:border-DMtext2'></input>
                        </div>
                    </div>

                    <div id='continueDiv' class='flex flex-col pt-4 place-items-center'> <!-- Continue Button -->
                        <p id="confirm-msg3" class="pb-2 text-lg text-center text-red-600"></p>
                        <button id='continue' type="button" class='px-16 text-lg border border-b-4 rounded continue h-fit w-fit border-LMtext1 dark:border-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Review and Pay</button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class='w-full text-lg md:w-1/3 text-LMtext1 dark:text-DMtext1'>
                    <h2 class='pb-2 text-2xl font-semibold'>Order Summary</h2>
                    <div class='w-full pt-5 mx-auto border-t-4 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->

                    <div class="flex items-center justify-between"> <!-- Subtotal -->
                        <p class="font-semibold">Subtotal</p>
                        <p id='subtotal'></p>
                    </div>
                    <div class="flex items-center justify-between pt-5"> <!-- Shipping -->
                        <p class="font-semibold">Shipping</p>
                        <p id='shippingPrice'></p>
                    </div>
                    <div id='discountDiv' class="flex items-center justify-between hidden pt-5"> <!-- Promo Discount -->
                        <p class="font-semibold">Discount &nbsp;<span id='promoCode' class='text-sm font-normal uppercase'></span></p>
                        <p id='discount'></p>
                    </div>
                    <div class="flex items-center justify-between py-5"> <!-- Tax -->
                        <p class="font-semibold">Tax</p>
                        <p id='tax'></p>
                    </div>

                    <div class='border-t-[1px] w-full mx-auto border-LMtext2 dark:border-DMtext2 pt-5'></div> <!-- Divider Bar -->

                    <div class="flex items-center justify-between pb-4"> <!-- Grand Total -->
                        <p class="text-xl font-semibold">Total</p>
                        <p id='total' class='text-xl'></p>
                    </div>

                    <div> <!-- Promo Code -->
                        <p>Have a promo code?</p>
                        <div class='flex gap-3'>
                            <input id='promoField' type='text' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'>
                            <button id='promoBtn' type="button" class='px-4 text-lg border border-b-2 rounded h-7 w-fit border-LMtext1 dark:border-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Submit</button>
                        </div>
                        <p id="confirm-msg4" class="py-2 text-sm text-red-600"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <my-header id=footer-ph w3-include-html='footer.html'></my-header>
    <script type="module" src="javascript/footer.js"></script>
</body>

</html>