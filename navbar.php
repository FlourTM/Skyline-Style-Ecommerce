<link href="./css/input.css" rel="stylesheet">
<link href="./css/output.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php session_start();?>
<nav class="navbar">
    <script type="module" src="javascript/navbar.js"></script>
    <div class='fixed top-0 left-0 z-20 w-full bg-LMbg dark:bg-DMbg'>
        <!-- Desktop Navbar -->
        <div class='items-center justify-between hidden px-5 py-3 border-b lg:flex border-LMtext2 dark:border-DMtext2'>
            <!-- Left Side of Navbar -->
            <ul class='flex items-center gap-12 text-lg font-medium text-LMtext1 dark:text-DMtext1'>
                <button id="women" type="button" class="nav-item">Women</button>
                <button id="men" type="button" class="nav-item">Men</button>
                <button id="jewelry" type="button" class="nav-item">Jewelry</button>
                <button id="bags" type="button" class="nav-item">Bags</button>
            </ul>

            <!-- Logo -->
            <a href="index" class="dark:hidden"><img id="LMlogo" src="./assets/LMlogo.svg"
                    class='w-[299px] h-[36px] dark:hidden'></img></a>
            <a href="index" class="hidden dark:block"><img id="DMlogo" src="./assets/DMlogo.svg"
                    class='w-[299px] h-[36px] hidden dark:block'></img></a>

            <!-- Right Side of Navbar -->
            <ul class='flex items-center gap-12 text-lg font-medium text-LMtext1 dark:text-DMtext1'>
                <div class='flex gap-12'>
                    <button id="acc" type="submit" name="myacc" class="nav-item"><?php if(isset($_SESSION['userid'])){?>Account<?php }else{ ?>Login/Signup<?php } ?></button>
                    <button id="wishlist" type="button" class="nav-item">Wishlist</button>
                    <button id="cart" type="button" class="nav-item">Cart</button>
                </div>

                <!-- Light/Dark Mode Icons -->
                <button class="theme-toggle" type="button">
                    <svg class="hidden w-8 h-8 theme-toggle-dark-icon" fill="#010101" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg class="hidden w-8 h-8 theme-toggle-light-icon" fill="#F1F1F1" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </ul>
        </div>

        <!-- Mobile Navbar -->
        <div class="lg:hidden">
            <!-- Navbar -->
            <div class='flex items-center justify-between px-3 py-3 border-b border-LMtext2 dark:border-DMtext2'>
                <a href="index" class="dark:hidden"><img id="LMlogo" src="./assets/LMlogo.svg"
                        class='h-8 dark:hidden'></img></a>
                <a href="index" class="hidden dark:block"><img id="DMlogo" src="./assets/DMlogo.svg"
                        class='hidden h-8 dark:block'></img></a>

                <!-- Light/Dark Mode Icons -->
                <div class="flex gap-1">
                    <button class="theme-toggle" type="button">
                        <svg class="hidden w-8 h-8 theme-toggle-dark-icon" fill="#010101" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg class="hidden w-8 h-8 theme-toggle-light-icon" fill="#F1F1F1" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <button id="mobileToggle" class='h-8 open'>
                        <i class="material-symbols-outlined" id="mobileClose" style="font-size:32px">menu</i>
                    </button>
                </div>

            </div>

            <!-- Menu Items -->
            <ul id='mobileMenu' class="flex flex-col hidden py-5 text-3xl font-bold leading-loose tracking-widest text-center uppercase border-b text-LMtext1 dark:text-DMtext1 border-LMtext2 dark:border-DMtext2">
                <li>Shop in</li>
                <div class='flex flex-col pb-3 font-medium tracking-normal normal-case leading-12'>
                    <button id="women" type="button" class="nav-item">Women</button>
                    <button id="men" type="button" class="nav-item">Men</button>
                    <button id="jewelry" type="button" class="nav-item">Jewelry</button>
                    <button id="bags" type="button" class="nav-item">Bags</button>
                </div>
                <li>Visit my</li>
                <button id="acc" type="submit" name="myacc" class="nav-item"><?php if(isset($_SESSION['userid'])){?>Account<?php }else{ ?>Login/Signup<?php } ?></button>
                <button id="wishlist" type="button" class="nav-item">Wishlist</button>
                <button id="cart" type="button" class="nav-item">Cart</button>
            </ul>
        </div>
    </div>

    <dialog id='loginRegisterOverlay' class='fixed z-10 flex justify-center hidden w-full h-full overflow-scroll pt-36 bg-black-rgba'>
        <div class='p-5 border-2 rounded border-LMtext1 dark:border-DMtext1 bg-LMbg dark:bg-DMbg w-96 h-fit '>
            <p id="error-msg" class="text-lg text-center text-red-600 confirm-message">
                <?php
                if (isset($_GET["msg"]) && $_GET["msg"] == 'success') {
                    session_start();
                    echo ($_SESSION["msg"]);
                } ?>
            </p>

            <div class='flex items-center justify-between pb-3'>
                <h1 id='header' class='text-3xl font-bold text-LMtext1 dark:text-DMtext1'>Log In</h1>
                <button id='close'><i class="material-icons" style="font-size:32px">close</i></button>
            </div>
            <!-- Login -->
            <form id='login' class='text-LMtext1 dark:text-DMtext1 '>
                <!-- Header -->
                <p class='pb-5 text-lg text-LMtext2 dark:text-DMtext2'>New to Skyline Style? <button id='loginToReg'
                        type='button' class='font-semibold'>Register here</button></p>

                <h2 class='pb-3 text-xl font-semibold'>Email</h2>
                <input id="lemail" name="lemail" type='email' placeholder='Email'
                    class='w-full px-2 text-lg bg-transparent border rounded pwFields border-LMtext2 dark:border-DMtext2'></input>

                <h2 class='pt-5 pb-3 text-xl font-semibold'>Password</h2>
                <div class='relative flex'>
                    <input id="lpass" name="lpassword" type='password' placeholder='Password'
                        class='w-full px-2 text-lg bg-transparent border rounded pwFields lpass border-LMtext2 dark:border-DMtext2'></input>
                    <button type="button"><i class="fa fa-eye-slash eyeIcon lpass"
                            style="font-size:24px;margin-left:-32px"></i></button>
                </div>

                <!-- Button -->
                <div class='flex justify-center'>
                    <button id='loginBtn' type="submit" class='px-8 my-8 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Log In</button>
                </div>

                <p class='text-lg'>By logging in, you agree to the Terms & Conditions and
                    Privacy Policy.</p>
            </form>

            <!-- Register -->
            <form id='register' class='hidden text-LMtext1 dark:text-DMtext1'>
                <p class='pb-5 text-lg text-LMtext2 dark:text-DMtext2'>Already have an account? <button id='regToLogin'
                        type='button' class='font-semibold'>Log in here</button></p>

                <!-- Name -->
                <div class='flex gap-5'>
                    <div>
                        <h2 class='pb-3 text-xl font-semibold'>First Name</h2>
                        <input id="rfirstName" name="firstName" type='text' placeholder='First Name'
                            class='w-full px-2 text-lg bg-transparent border rounded pwFields border-LMtext2 dark:border-DMtext2'></input>
                    </div>
                    <div>
                        <h2 class='pb-3 text-xl font-semibold'>Last Name</h2>
                        <input id="rlastName" name="lastName" type='text' placeholder='Last Name'
                            class='w-full px-2 text-lg bg-transparent border rounded pwFields border-LMtext2 dark:border-DMtext2'></input>
                    </div>
                </div>

                <h2 class='pt-5 pb-3 text-xl font-semibold'>Email</h2>
                <input id="remail" name="remail" type='email' placeholder='Email'
                    class='w-full px-2 text-lg bg-transparent border rounded pwFields border-LMtext2 dark:border-DMtext2'></input>

                <h2 class='pt-5 pb-3 text-xl font-semibold'>Password</h2>
                <div class='relative flex'>
                    <input id="rpass" name="rpassword" type='password' placeholder='Password'
                        class='w-full px-2 text-lg bg-transparent border rounded pwFields rpass border-LMtext2 dark:border-DMtext2'></input>
                    <button type="button"><i class="fa fa-eye-slash eyeIcon rpass"
                            style="font-size:24px;margin-left:-32px"></i></button>
                </div>

                <h2 class='pt-5 pb-3 text-xl font-semibold'>Confirm Password</h2>
                <div class='relative flex'>
                    <input id="rconfirm" name="confirmpassword" type='password' placeholder='Password'
                        class='w-full px-2 text-lg bg-transparent border rounded pwFields rconfirm border-LMtext2 dark:border-DMtext2'></input>
                    <button type="button"><i class="fa fa-eye-slash eyeIcon rconfirm"
                            style="font-size:24px;margin-left:-32px"></i></button>
                </div>

                <!-- Button -->
                <div class='flex justify-center'>
                    <button id='registerBtn' type="submit" class='px-8 my-8 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>Register</button>
                </div>

                <p class='text-lg'>By creating an account, you agree to the Terms &
                    Conditions and Privacy Policy.</p>
            </form>
        </div>
    </dialog>
</nav>
<?php include('php\cms.php');?>  <!--Loads cms upon pageload so we don't have to worry about loading it again -->