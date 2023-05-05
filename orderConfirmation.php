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
    <title>Order Confirmation</title>
</head>

<body>
    <!-- Navigation Bar -->
    <my-header id=nav-ph w3-include-html='navbar.php'></my-header>
    <script type="module" src="javascript/navbar.js"></script>
    <script type="module">
        if (localStorage.getItem('money_info')) {
            var money_info = JSON.parse(localStorage['money_info'] || "{}")
            if (money_info.checkout) {
                document.getElementById('total').innerHTML = `$${money_info.total.toFixed(2)}`
                document.getElementById('order#').innerHTML = money_info.orderid
                document.getElementById('orderNumber').innerHTML = `#${money_info.orderid}`
                var d = new Date();
                var dd = String(d.getDate()).padStart(2, '0')
                var mm = String(d.getMonth() + 1).padStart(2, '0')
                var yyyy = d.getFullYear()
                var date = `${mm}/${dd}/${yyyy}`
                document.getElementById('date').innerHTML = date
                if (money_info.express) {
                    document.getElementById('s_method').innerHTML = 'Express'
                } else {
                    document.getElementById('s_method').innerHTML = 'Standard'
                }

                localStorage.removeItem('money_info')
            } else {
                window.location = 'index'
            }
        } else {
            window.location = 'index'
        }

    </script>

    <!-- Header -->
    <div name="OrderConfirmation" class='flex flex-col justify-between w-full min-h-screen bg-LMbg dark:bg-DMbg'>
        <div class='px-12 pb-8 my-auto lg:px-36 text-LMtext1 dark:text-DMtext1'>
            <h1 class='pb-12 text-4xl font-bold text-center'>Thank you!</h1>

            <h2 class="text-2xl text-center">Your order <span id='orderNumber' class='font-semibold'></span> has
                been placed.</h2>
            <p class='pt-6 text-xl text-center'>We are getting started on your order right away, and you'll receive an
                order confirmation email shortly.</p>

            <div class='w-full max-w-[550px] mx-auto pt-12'>
                <h3 class='text-3xl font-semibold'>Order Details</h3>
                <div class='border-t-[1px] w-full mx-auto border-LMtext2 dark:border-DMtext2 pt-5'></div>
                <!-- Divider Bar -->

                <div class='grid gap-4 text-center sm:grid-cols-2'>
                    <div>
                        <h4 class='text-2xl font-semibold'>Order Total</h4>
                        <p id='total' class='text-xl'></p>
                    </div>
                    <div>
                        <h4 class='text-2xl font-semibold'>Order Number</h4>
                        <p id = 'order#' class='text-xl'>101</p>
                    </div>
                    <div>
                        <h4 class='text-2xl font-semibold'>Order Date</h4>
                        <p id='date' class='text-xl'></p>
                    </div>
                    <div>
                        <h4 class='text-2xl font-semibold'>Shipping Method</h4>
                        <p id="s_method" class='text-xl'></p>
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