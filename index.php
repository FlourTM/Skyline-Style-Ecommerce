<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/output.css" rel="stylesheet">
    <link rel="icon" href="./assets/DMicon.png">
    <title>Skyline Style</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script type="module" src="javascript/navbar.js"></script>

    <div name="Home" class='flex flex-col justify-between w-full min-h-screen bg-LMbg dark:bg-DMbg'>
        <div class='pt-20 lg:pt-24'>
            <!-- Header -->
            <div class='relative mb-16'>
                <!-- Title Box -->
                <div class='absolute inset-0 flex flex-col items-center px-20 py-8 m-auto rounded bg-LMbg dark:bg-DMbg bg-opacity-90 dark:bg-opacity-90 w-fit h-fit'>
                    <h1 class='pb-3 text-2xl text-center text-LMtext1 dark:text-DMtext1'>Welcome to</h1>
                    <img src="./assets/LMlogo.svg" alt='Skyline Style Logo' class='LMsvg w-[299px] h-[36px] dark:hidden'></img>
                    <img src="./assets/DMlogo.svg" alt='Skyline Style Logo' class='DMsvg w-[299px] h-[36px] hidden dark:block'></img>
                </div>
                <!-- Images -->
                <div class='grid grid-cols-2 sm:flex'>
                    <img src='https://images.pexels.com/photos/1090387/pexels-photo-1090387.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' alt='Woman in gray shirt with jean jacket' class='object-cover object-center bg-white sm:w-1/4 aspect-square' />
                    <img src='https://images.unsplash.com/photo-1606760227091-3dd870d97f1d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80' alt='Bundle of silver, gold, and bronze jewelry' class='object-cover object-center bg-white sm:w-1/4 aspect-square' />
                    <img src='https://media.istockphoto.com/id/1318783732/photo/womens-bags-on-showcase-in-store.jpg?b=1&s=170667a&w=0&k=20&c=l7uTuExzxxngZkmlqdfLrWN8UlgECorDKHK_FETxAYs=' alt='Various types of cream, light blue, yellow, and white bags' class='object-cover object-center bg-white sm:w-1/4 aspect-square' />
                    <img src='https://images.pexels.com/photos/878358/pexels-photo-878358.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1' alt='Man wearing a white long-sleeve with black jeans' class='object-cover object-center bg-white sm:w-1/4 aspect-square' />
                </div>
            </div>

            <!-- Content -->
            <div class='grid gap-6 px-12 pb-12 sm:px-24 sm:gap-16 place-items-center sm:grid-cols-2'>
                <!-- Women -->
                <div class=''>
                    <div class='flex items-center justify-between pb-3'>
                        <h2 class='text-3xl font-semibold text-LMtext1 dark:text-DMtext1'>Women</h2>
                        <a href="women" type="submit" class='px-2 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>View More</a>
                    </div>
                    <div class='grid grid-cols-2 gap-6'>
                        <img src='https://edge.curalate.com/v1/img/aP83gTHR0OeZiRENUeJQ02NrqIHGzzDg1Jz8urXvTl8=/sc/2768x2768?compression=0.85&fit=crop' alt='image1' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://img.ltwebstatic.com/images3_pi/2021/08/10/162856457843b1194b381289b8b608bcfdf9360d75_thumbnail_900x.webp' alt='image2' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://www.lulus.com/images/product/xlarge/5065770_1112462.jpg?w=560&hdpi=1' alt='image3' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                        <img src='https://cdn.shopify.com/s/files/1/0293/9277/products/Plot_Twist_Heel_-_Black_JK_468x@2x.jpg?v=1677732222' alt='image4' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                    </div>
                </div>

                <!-- Men -->
                <div class=''>
                    <div class='flex items-center justify-between pb-3'>
                        <h2 class='text-3xl font-semibold text-LMtext1 dark:text-DMtext1'>Men</h2>
                        <a href="men" type="submit" class='px-2 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>View
                            More</a>
                    </div>
                    <div class='grid grid-cols-2 gap-6'>
                        <img src='https://cdn.shopify.com/s/files/1/0293/9277/products/12-16-22Studio5_RD_DJ_10-25-48_31_FNMN490_Black_P_9289_SG_360x.jpg?v=1671499275' alt='image1' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://m.media-amazon.com/images/I/71WNFiCpjrL._AC_UL1500_.jpg' alt='image2' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://i.pinimg.com/736x/03/cf/8d/03cf8df91d9dee47b8bf97a4c13757c3.jpg' alt='image3' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                        <img src='http://cdn.shopify.com/s/files/1/0293/9277/products/12-15-22Studio5_RT_DJ_15-06-16_85_FNMH1328_BrownCombo_0189_SG_1200x1200.jpg?v=1671218722' alt='image4' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                    </div>
                </div>

                <!-- Jewelry -->
                <div class=''>
                    <div class='flex items-center justify-between pb-3'>
                        <h2 class='text-3xl font-semibold text-LMtext1 dark:text-DMtext1'>Jewelry</h2>
                        <a href="jewelry" type="submit" class='px-2 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>View More</a>
                    </div>
                    <div class='grid grid-cols-2 gap-6'>
                        <img src='https://www.vancleefarpels.com/content/dam/rcq/vca/19/13/10/4/1913104.png.transform.vca-w820-2x.png' alt='image1' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://www.davidyurman.com/dw/image/v2/BGCL_PRD/on/demandware.static/-/Sites-dy-master-catalog/default/dwac53b405/images/hi-res/onmodel/B05524MSSRBRBLK_ONMODEL.jpg?ch=3651&cw=6477&cx=0&cy=263&https%3A%2F%2Fwww.davidyurman.com%2Fdw%2Fimage%2Fv2%2FBGCL_PRD%2Fon%2Fdemandware.static%2F-%2FSites-dy-master-catalog%2Fdefault%2Fdwac53b405%2Fimages%2Fhi-res%2Fonmodel%2FB05524MSSRBRBLK_ONMODEL.jpg=undefined&sm=fit&sw=3000&sh=3000' alt='image2' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://cdn.shopify.com/s/files/1/2417/4137/products/7mmcubangold2_1080x1080_crop_center.jpg.webp?v=1669064813' alt='image3' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                        <img src='https://www.zales.com/productimages/processed/V-20313066_1_800.jpg?pristine=true' alt='image4' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                    </div>
                </div>

                <!-- Bags -->
                <div class=''>
                    <div class='flex items-center justify-between pb-3'>
                        <h2 class='text-3xl font-semibold text-LMtext1 dark:text-DMtext1'>Bags</h2>
                        <a href="bags" type="submit" class='px-2 text-lg border border-b-4 rounded w-fit border-LMtext1 dark:border-DMtext1 text-LMtext1 dark:text-DMtext1 hover:bg-LMtext1 dark:hover:bg-DMtext1 hover:text-LMbg dark:hover:text-DMbg'>View More</a>
                    </div>
                    <div class='grid grid-cols-2 gap-6'>
                        <img src='https://media.graphassets.com/uveeozqiQ7WtjY09EKI7' alt='image1' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://media.graphassets.com/VN29CInvSobb6bfEcd3p' alt='image2' class='object-cover object-center bg-white w-80 aspect-square' />
                        <img src='https://media.graphassets.com/t08xSyu4SIySUTp17Uk1' alt='image3' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                        <img src='https://media.graphassets.com/jchvRYPT3SoZXpGJOuBg' alt='image4' class='hidden object-cover object-center bg-white w-80 sm:block aspect-square' />
                    </div>
                </div>
            </div>

            <!-- Short About -->
            <div>
                <!-- Divider Bar -->
                <div class='w-11/12 py-5 mx-auto border-t-2 border-LMtext2 dark:border-DMtext2'></div>
                
                <div class='px-12'>
                    <h1 class='text-2xl font-bold text-center text-LMtext1 dark:text-DMtext1'>A modern clothing
                        website based in the United States.</h1>
                    <p class='pb-8 mx-auto text-lg text-LMtext2 dark:text-DMtext2 lg:w-4/5'>Skyline Style is a well-trusted source for finding the finest
                        selection of apparel for young men and young women. Our expert buying team searches around the globe with a simple mission: to bring the
                        finest fashion directly to your doorstep. With an easy-to-navigate platform to shop on-the-go, we ensure a boutique-like feeling for a
                        unique shopping experience.</p>
                    <div class='w-11/12 gap-20 mx-auto lg:flex lg:w-4/5'>
                        <div>
                            <h2 class='text-xl font-semibold text-center text-LMtext1 dark:text-DMtext1 lg:text-left'>
                                Shopping Experience</h2>
                            <ul class='pt-3 pb-10 pl-5 list-disc text-LMtext2 dark:text-DMtext2 text-md'>
                                <li>The finest edit of more than 100 international stylish brands</li>
                                <li>New arrivals each week directly</li>
                                <li>Well-curated selection of items for a boutique-like shopping experience</li>
                            </ul>
                        </div>
                        <div>
                            <h2 class='text-xl font-semibold text-center text-LMtext1 dark:text-DMtext1 lg:text-left'>
                                Service and Quality</h2>
                            <ul class='pt-3 pb-10 pl-5 list-disc text-LMtext2 dark:text-DMtext2 text-md'>
                                <li>Authentic products guaranteed</li>
                                <li>Exceptional customer service available 24 hours a day, 7 days a week</li>
                                <li>Fast, reliable delivery to the United States within 2-5 business days</li>
                            </ul>
                        </div>
                    </div>
                    <p class='pb-8 mx-auto text-lg text-LMtext2 dark:text-DMtext2 lg:w-4/5'>Get inspired by our coveted edit, which makes occasion dressing easy 
                        by breaking down our buy into easy-to-shop categories such as jewelry and bags. Delve into our exclusive selection of stylish must-haves. Our 
                        exceptional customer service team is here to help you through every step of the order process, and beyond, to make sure you start every day 
                        dressed to conquer.</p>
                    <h1 class='pb-10 text-2xl font-bold text-center text-LMtext1 dark:text-DMtext1'>Shop with us and discover why Skyline Style is your final 
                        destination for online shopping.</h1>
                </div>

                <!-- Divider Bar -->
                <div class='w-11/12 py-5 mx-auto border-t-2 border-LMtext2 dark:border-DMtext2'></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <my-header id=footer-ph w3-include-html='footer.html'></my-header>
    <script type="module" src="javascript/footer.js"></script>
</body>

</html>