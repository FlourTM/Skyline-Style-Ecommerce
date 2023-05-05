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
    <title>My Account</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script src="javascript/functions.js"></script>
    <script type="module" src="javascript/navbar.js"></script>
    <script type="module" src="javascript/account.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>    
    <?php
    $user = false;
    $addresses;
    $orders;
    if (isset($_SESSION['userid'])){
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
        
        $ordersql = sprintf(
            "SELECT * FROM orders WHERE userID = '%s' ORDER BY `date` DESC",
            $mysqli->real_escape_string($_SESSION['userid'])
        );
        $orders = $mysqli->query($ordersql);
    }
    if ($user) {
    ?>

        <div name="Account" class='flex flex-col justify-between w-full min-h-screen bg-LMbg dark:bg-DMbg'>
            <div class='flex flex-col items-center justify-center px-8 pb-8 sm:px-12 pt-36 lg:block'>
                <!-- Header -->
                <h1 class='text-4xl font-bold text-center text-LMtext1 dark:text-DMtext1'>My Account</h1>
                <p class="pb-8 text-lg text-center notYou text-LMtext1 dark:text-DMtext1">Not you?
                    <button type="submit" id="logout" class="font-semibold logout" name="logout">Sign out now.</button>
                </p>

                <div class='grid justify-center gap-2 pb-8 text-xl font-semibold sm:flex sm:gap-x-12 text-LMtext1 dark:text-DMtext1'> <!-- Navigation -->
                    <button id='info' class="accountNav active">Personal Information</button>
                    <button id='addr' class="accountNav">Addresses</button>
                    <button id='orders' class="accountNav">Order History</button>
                </div>

                <p id="confirm-msg" class="text-lg text-center text-red-600 message"></p>

                <!-- Personal Information -->
                <div class='section info mx-auto w-full max-w-[500px] h-fit'>
                    <h2 class='text-3xl font-bold text-center text-LMtext1 dark:text-DMtext1'>Personal Information</h2>
                    <!-- Account Details -->
                    <form id="accountForm" class="text-LMtext2 dark:text-DMtext2">
                        <div class='flex pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 whitespace-nowrap'>First Name:</p>
                            <input id="fName" name="firstname" type='text' placeholder='<?= $user["firstName"] ?>' value='<?= $user["firstName"] ?>' class='w-full px-2 text-xl bg-transparent rounded outline-none input1 ' readonly></input>
                        </div>
                        <p id="fNameMsg" class="text-sm text-center text-red-600 message"></p>
                        <div class='flex pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 whitespace-nowrap'>Last Name:</p>
                            <input id="lName" name="lastname" type='text' placeholder='<?= $user["lastName"] ?>' value='<?= $user["lastName"] ?>' class='w-full px-2 text-xl bg-transparent rounded outline-none input1 ' readonly></input>
                        </div>
                        <p id="lNameMsg" class="text-sm text-center text-red-600 message"></p>
                        <div class='flex pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 whitespace-nowrap'>Email:</p>
                            <input id="email" name="email" type='email' placeholder='<?= $user["email"] ?>' value='<?= $user["email"] ?>' class='w-full px-2 text-xl bg-transparent rounded outline-none input1 ' readonly></input>
                        </div>
                        <p id="emailMsg" class="text-sm text-center text-red-600 message"></p>
                        <div class='flex pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 whitespace-nowrap'>Phone:</p>
                            <input id="phone" name="phone" type='tel' placeholder='<?= $user["phone"] ?>' value='<?= $user["phone"] ?>' onkeypress="return /[0-9]/i.test(event.key)" maxlength='10' class='w-full px-2 text-xl bg-transparent rounded outline-none input1' readonly></input>
                        </div>
                        <p id="phoneMsg" class="text-sm text-center text-red-600 message"></p>
                    </form>

                    <!-- Password -->
                    <form id="passForm" class='hidden text-LMtext2 dark:text-DMtext2'>
                        <div class='flex flex-col w-full pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1'>Current Password:</p>
                            <div class="flex">
                                <input id="current" name="current" type='password' class='w-full px-2 text-xl bg-transparent border-b rounded pwFields current border-LMtext1 dark:border-DMtext1'></input>
                                <button type="button"><i class="fa fa-eye-slash eyeIcon current" style="font-size:24px;margin-left:-32px"></i></button>
                            </div>
                        </div>
                        <div class='flex flex-col pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 w-fit'>New Password:
                            </p>
                            <div class="flex">
                                <input id="new" name="new" type='password' class='w-full px-2 text-xl bg-transparent border-b rounded pwFields new border-LMtext1 dark:border-DMtext1'></input>
                                <button type="button"><i class="fa fa-eye-slash eyeIcon new" style="font-size:24px;margin-left:-32px"></i></button>
                            </div>
                        </div>
                        <div class='flex flex-col pt-5'>
                            <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 w-fit'>Confirm
                                Password:</p>
                            <div class="flex">
                                <input id="confirm" name="confirm" type='password' class='w-full px-2 text-xl bg-transparent border-b rounded pwFields confirm border-LMtext1 dark:border-DMtext1'></input>
                                <button type="button"><i class="fa fa-eye-slash eyeIcon confirm" style="font-size:24px;margin-left:-32px"></i></button>
                            </div>
                        </div>
                    </form>

                    <!-- Information Buttons -->
                    <div class='flex justify-center pt-5'>
                        <button id="edit" type="button" class='px-8 text-lg border border-b-4 rounded edit w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Edit
                            Details</button>
                    </div>
                    <div class='flex justify-center pt-3'>
                        <button id="change" type="button" class='px-8 text-lg border border-b-4 rounded change w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Change
                            Password</button>
                    </div>
                </div>

                <!-- Address -->
                <div class='section addr hidden mx-auto w-full max-w-[500px] h-fit'>
                    <h2 class='text-3xl font-bold text-center text-LMtext1 dark:text-DMtext1'>Addresses</h2>

                    <!-- Address Information -->
                    <div id='addressInfo'>
                        <p class='pt-8 pb-2 pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1'>Saved Addresses:</p>
                        <p id="addressText" class='text-xl text-LMtext-2 dark:text-DMtext2'>
                            <div id = 'addrContainer' class='max-h-[450px] overflow-y-auto px-2'> 
                            <?php 
                            if ($addresses) {
                                if (mysqli_num_rows($addresses) > 0) {
                                    ?> <?php
                                    while ($row = mysqli_fetch_assoc($addresses)) { ?> 
                                        <div id = 'addrbox' class='pb-5'>
                                            <div class='flex justify-between'>
                                                <div class='text-xl text-LMtext-2 dark:text-DMtext2'>
                                                    <p><?=$row["firstName"]?> <?=$row["lastName"] ?></p>
                                                    <p><?=$row["company"]?></p>
                                                    <p><?=$row["address1"]?>, </p>
                                                    <?php if ($row['address2']) {
                                                    ?> <p><?=$row["address2"]?>, </p>
                                                    <?php } ?>                                            
                                                    <p class='pb-5'><?=$row["city"]?>, <?=$row["stateAbbr"]?> <?=$row["zip"]?></p>
                                                </div>
                                                <button id=<?=$row["id"]?> class='px-8 text-lg border border-b-4 rounded deleteAddr w-fit h-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Remove</button>
                                            </div>
                                            <div class='w-full mx-auto border-t-2 border-LMtext2 dark:border-DMtext2'></div>
                                        </div> <?php
                                    } 
                                } else { ?> <p class='text-xl text-LMtext-2 dark:text-DMtext2'>No addresses added.</p> <?php } ?> <?php
                            } ?>
                            </div> 
                        </p>
                    </div>

                    <form id="addressForm" class="hidden pt-5 text-LMtext2 dark:text-DMtext2">
                        <div class='grid grid-flow-col gap-4'> <!-- Names -->
                            <div>
                                <p class='pb-1 text-lg font-semibold'>First Name</p>
                                <input id="firstName" name="firstName" type='text' placeholder='First Name' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                            </div>
                            <div>
                                <p class='pb-1 text-lg font-semibold'>Last Name</p>
                                <input id="lastName" name="lastName" type='text' placeholder='Last Name' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                            </div>
                        </div>
                        <div class='py-5'> <!-- Company -->
                            <p class='pb-1 text-lg font-semibold'>Company (Optional)</p>
                            <input id="company" name="company" type='text' placeholder='Company' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                        </div>
                        <div class='grid gap-4 pb-5 md:grid-flow-col'> <!-- Street Address -->
                            <div>
                                <p class='pb-1 text-lg font-semibold'>Address 1</p>
                                <input id="address1" name="address1" type='text' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                            </div>
                            <div>
                                <p class='pb-1 text-lg font-semibold'>Address 2 (Optional)</p>
                                <input id="address2" name="address2" type='text' class='w-full px-2 text-lg bg-transparent border rounded h-7 border-LMtext2 dark:border-DMtext2'></input>
                            </div>
                        </div>
                        <div class='grid grid-flow-col gap-4 pb-5'> <!-- City, State, Zip -->
                            <div>
                                <p class='pb-1 text-lg font-semibold'>City</p>
                                <input id="city" name="city" type='text' class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                            </div>
                            <div>
                                <p class='pb-1 text-lg font-semibold'>State</p>
                                <select id='state' name="state" class="w-full text-lg bg-transparent border rounded input2 h-7 bg-LMbg dark:bg-DMbg border-LMtext1 dark:border-DMtext1">
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
                                <input id="zip" name="zip" type='text' onkeypress="return /^\d|-$/i.test(event.key)" maxlength="10" class='w-full px-2 text-lg bg-transparent border rounded input2 h-7 border-LMtext2 dark:border-DMtext2'></input>
                                <p id="zipMsg" class="pb-2 text-sm text-center text-red-600"></p>
                            </div>
                        </div>
                    </form>
                    <div class='flex justify-center pt-5'>
                        <button id="addressBtn" type="button" class='px-8 text-lg border border-b-4 rounded add w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Add New Address</button>
                    </div>
                    <div class='flex justify-center pt-5'>
                        <button id="cancelAddr" type="button" class='hidden px-8 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Cancel</button>
                    </div>
                </div>

                <!-- Order History -->
                <div class='section orders hidden mx-auto w-full max-w-[600px] h-fit'>
                    <h2 class='pb-5 text-3xl font-bold text-center text-LMtext1 dark:text-DMtext1'>Order History</h2>

                    <!-- Need a PHP statement for the following, similar to address setup -->
                <?php if ($orders){
                        if (mysqli_num_rows($orders) > 0) {
                            ?> <div class='h-[450px] overflow-y-auto px-2'> <?php
                            while ($row = mysqli_fetch_assoc($orders)) {
                                $datefromSQL = $row['date'];
                                $orderDate = date("m/d/Y", strtotime($datefromSQL));?>
                                <!-- Individual Order -->
                                <div class='pb-5'>
                                    <div class='items-center justify-between pb-5 sm:flex'>
                                        <p class='pr-2 text-2xl font-semibold text-LMtext1 dark:text-DMtext1 whitespace-nowrap'>Order Number: <span>#<?=$row['id']?></span></p>
                                        <div class='pr-2 text-xl text-LMtext1 dark:text-DMtext1 whitespace-nowrap'>
                                            <p>Order Total: <span>$<?=$row['total']?></span></p>
                                            <p>Order Date: <span><?=$orderDate?></span></p>
                                            <p>Shipping Method: <span><?=$row['shipMethod']?></span></p>
                                        </div>
                                    </div>
                                    <div class='w-full mx-auto border-t-2 border-LMtext2 dark:border-DMtext2'></div> <!-- Divider Bar -->
                                </div>
                            <?php } 
                        ?> </div> <?php } else { ?>
                         <!-- If no orders -->
                        <p class='text-2xl font-semibold text-center text-LMtext1 dark:text-DMtext1'>No orders have been placed.</p>
                    <?php } } ?>
                </div>
            </div>
        </div>
    <?php
        $mysqli->close();
    } else {
        echo ('<script>window.location = "index"</script>');
    }
    ?>

    <!-- Footer -->
    <my-header id=footer-ph w3-include-html='footer.html'></my-header>
    <script type="module" src="javascript/footer.js"></script>
</body>

</html>