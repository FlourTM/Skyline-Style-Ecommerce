const sAddressBtn = document.getElementById('sAddressBtn'),
    sAddressForm = document.getElementById('sAddressForm'),
    sSaveAddr = document.getElementById('sSaveAddr'),
    bAddressBtn = document.getElementById('bAddressBtn'),
    bAddressForm = document.getElementById('bAddressForm'),
    sZipMsg = document.getElementById('sZipMsg'),
    availableShips = document.querySelectorAll('.availableShips'),
    bZipMsg = document.getElementById('bZipMsg'),
    availableBills = document.querySelectorAll('.availableBills'),
    shipConfirmMsg = document.getElementById('confirm-msg1'),
    billConfirmMsg = document.getElementById('confirm-msg2'),
    continueMsg = document.getElementById('confirm-msg3'),
    promoMsg = document.getElementById('confirm-msg4'),
    continueBtn = document.getElementById('continue'),
    goBack = document.getElementById('goBack'),
    standardBtn = document.getElementById('standard'),
    expressBtn = document.getElementById('express'),
    addresses = document.getElementById('addresses'),
    payment = document.getElementById('payment'),
    sAddressInputs = document.querySelectorAll('.input1'),
    bAddressInputs = document.querySelectorAll('.input2'),
    paymentInputs = document.querySelectorAll('.input3'),
    continueDiv = document.getElementById('continueDiv'),
    subtotal = document.getElementById('subtotal'),
    shipping = document.getElementById('shippingPrice'),
    discount = document.getElementById('discount'),
    discountDiv = document.getElementById('discountDiv'),
    promoCode = document.getElementById('promoCode'),
    tax = document.getElementById('tax'),
    total = document.getElementById('total'),
    promo = document.getElementById('promoField'),
    promobtn = document.getElementById('promoBtn')

var validZip = /(^\d{5}$)|(^\d{5}-\d{4}$)/;

//  Money Stuff :D
var static_info = JSON.parse(localStorage['money_info'] || "{}")
var money_info = JSON.parse(localStorage['money_info'] || "{}")
var reduction = 0.00
var per_reduct = 0

// Updates the stuff
function updateSummary() {
    // Checking for free shipping
    if (money_info.free_ship) {
        shipping.innerHTML = 'FREE'
        document.getElementById('standardVal').innerHTML = shipping.innerHTML
        standardBtn.checked = true
        expressBtn.checked = false
        money_info.express = false
    } else {
        shipping.innerHTML = `$${money_info.shipping}`
        document.getElementById('standardVal').innerHTML = `$${static_info.standard}`
        standardBtn.checked = true
        expressBtn.checked = false
        money_info.express = false
    }
    if (money_info.shipping) {
        shipping.innerHTML = `$${money_info.shipping}`
        if (money_info.shipping > 4.99){
            standardBtn.checked = false
            expressBtn.checked = true
            money_info.express = true
        }else{
            standardBtn.checked = true
            expressBtn.checked = false
            money_info.express = false
        }
    }

    // Applying the discount "per_reduct = percentage reduced"
    if (!per_reduct > 0) {
        money_info.discount = Number(reduction)
        discount.innerHTML = `-$${Number(reduction).toFixed(2)}`
    } else {
        money_info.discount = Number((money_info.subtotal * per_reduct).toFixed(2))
        discount.innerHTML = `-$${money_info.discount.toFixed(2)}`
    }

    // Calculating the order total
    var orderTotal = money_info.subtotal - money_info.discount + money_info.shipping
    money_info.tax = Number(((money_info.subtotal - money_info.discount) * money_info.tax_rate).toFixed(2))
    money_info.total = Number((orderTotal + money_info.tax).toFixed(2))

    // Setting HTMLs once everything has been calculated
    tax.innerHTML = `$${money_info.tax.toFixed(2)}`
    subtotal.innerHTML = `$${money_info.subtotal.toFixed(2)}`
    total.innerHTML = `$${money_info.total.toFixed(2)}`

    // Updating the server with new values
    for (let i = 0; i < Object.keys(money_info).length; i++) {
        if (Object.values(money_info)[i] === Object.values(static_info)[i]) {
        } else {
            localStorage.setItem('money_info', JSON.stringify(money_info))
            static_info = JSON.parse(localStorage['money_info'] || "{}")
        }
    }
}

// Loads info upon window load
window.onload = function () {
    updateSummary()
}

// Standard Shipping Button
standardBtn.addEventListener('click', () => {
    if (money_info.free_ship) {
        money_info.shipping = 0
    } else {
        money_info.shipping = 4.99
    }
    money_info.express = false
    updateSummary()
})

// Express Shipping Button
expressBtn.addEventListener('click', () => {
    money_info.shipping = 9.99
    money_info.express = true
    updateSummary()
})

// Funciton to send promocode information to server
function sendCode() {
    var postRequest = new XMLHttpRequest();
    var url = './php/wishandcart.php';
    postRequest.open('POST', url, true);
    postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    postRequest.send(`promo=${promo.value}`);
    postRequest.onreadystatechange = function () {
        if (postRequest.readyState == 4 && postRequest.status == 200) {
            var fix = (postRequest.responseText).replaceAll('\\', '')
            if (Number(fix) > 0) {
                reduction = fix
                per_reduct = 0
                promoCode.innerHTML = `(${promo.value})`
                discountDiv.classList.remove('hidden')
                promo.value = ''
                message(promoMsg,'Discount applied successfully!')
                updateSummary()
            } else if (fix.includes('%')) {
                fix = Number((postRequest.responseText).replaceAll('%', '')) / 100
                reduction = 0
                per_reduct = fix
                promoCode.innerHTML = `(${promo.value})`
                discountDiv.classList.remove('hidden')
                promo.value = ''
                message(promoMsg,'Discount applied successfully!')
                updateSummary()
            } else {
                message(promoMsg,'Invalid promo code!')
            }
        }
    }
}

// Pressing Enter to Submit PromoCode
document.addEventListener('keydown', e => {
    if (e.key == 'Enter' && document.activeElement === promo) {
        if (promo.value) {
            sendCode()
        }
    }
})

// Promo Code Submit Button
promobtn.addEventListener('click', () => {
    if (promo.value) {
        sendCode()
    }
})

// Shipping Address
var shipChosen = null;
var shipRadios = document.getElementsByName('sAddrSelection'),
    sFirstName = document.getElementById('sFirstName'),
    sLastName = document.getElementById('sLastName'),
    sCompany = document.getElementById('sCompany'),
    sAddress = document.getElementById('sAddress1'),
    sAddress2 = document.getElementById('sAddress2'),
    sCity = document.getElementById('sCity'),
    sState = document.getElementById('sState'),
    sZip = document.getElementById('sZip')

// Billing Address
var billChosen = null;
var billRadios = document.getElementsByName('bAddrSelection'),
    bZip = document.getElementById('bZip')

// Payment Method
var ccNumber = document.getElementById('ccNumber'),
    expireMM = document.getElementById('expireMM'),
    expireYY = document.getElementById('expireYY'),
    secCode = document.getElementById('secCode'),
    cardName = document.getElementById('cardName')

// Shipping Zip Code Verification
sZip.addEventListener('input', () => {
    if (!sZip.value.match(validZip)) {
        sZipMsg.innerHTML = "Please check your zip code."
    } else {
        sZipMsg.innerHTML = ""
    }
})

// Billing Zip Code Verification
bZip.addEventListener('input', () => {
    if (!bZip.value.match(validZip)) {
        bZipMsg.innerHTML = "Please check your zip code."
    } else {
        bZipMsg.innerHTML = ""
    }
})

// Card Number Spaces and Verification
ccNumber.addEventListener('input', () => {
    var cardNo = ccNumber.value.split(" ").join("");
    if (cardNo.length > 0) {
        cardNo = cardNo.match(new RegExp('.{1,4}', 'g')).join(" ");
    }

    if (cardNo.length < 19) {
        continueMsg.innerHTML = "Please check your card number."
    } else {
        continueMsg.innerHTML = ""
    }
    ccNumber.value = cardNo;
})

// Shipping Address Buttons
for (let i = 0; i < availableShips.length; i++) {
    availableShips[i].addEventListener('click', e => {
        sAddressForm.classList.add('hidden')
        availableShips[i].classList.add('peer-checked:border-accentPink', 'peer-checked:border-4')
        sAddressBtn.classList.remove('ready')
    })
}

// Shipping Address Verification for Add New Address
sAddressBtn.addEventListener('click', e => {
    e.preventDefault();

    if (sAddressBtn.classList.contains('add')) { // Opens the form to allow for editing
        sAddressBtn.classList.replace('add', 'save')
        sAddressBtn.innerHTML = 'Use this address'
        sAddressBtn.type = 'submit'
        sAddressForm.classList.remove('hidden')
        for (let i = 0; i < sAddressInputs.length; i++) {
            sAddressInputs[i].removeAttribute('readonly')
            sSaveAddr.removeAttribute('readonly')
            sSaveAddr.removeAttribute('disabled')
        }
    } else { // Checks the user's inputted information for verification
        for (let i = 0; i < sAddressInputs.length; i++) {
            if (!sAddressInputs[i].value) {
                shipConfirmMsg.innerHTML = "Please fill in missing fields."
                return;
            }
        }

        if (!sZipMsg.innerHTML == "") {
            shipConfirmMsg.innerHTML = "Please check your zip code."
        } else { // If all is good, save the information and close the fields
            shipConfirmMsg.innerHTML = ""
            sAddressBtn.type = "button"
            sAddressBtn.classList.replace("save", "add")
            sAddressBtn.classList.add('ready')
            sAddressBtn.innerHTML = 'Use different address'
            shipChosen = null;

            for (let i = 0; i < sAddressInputs.length; i++) {
                sAddressInputs[i].setAttribute('readonly', 'readonly')
                sSaveAddr.setAttribute('readonly', 'readonly')
                sSaveAddr.setAttribute('disabled', 'disabled')
            }

            for (let i = 0; i < availableShips.length; i++) {
                availableShips[i].classList.remove('peer-checked:border-accentPink', 'peer-checked:border-4')
            }

            for (let i = 0; i < shipRadios.length; i++) {
                shipRadios[i].checked = false
            }
        }
    }
})

// Billing Address Buttons
for (let i = 0; i < availableBills.length; i++) {
    availableBills[i].addEventListener('click', e => {
        bAddressForm.classList.add('hidden')
        availableBills[i].classList.add('peer-checked:border-accentPink', 'peer-checked:border-4')
        bAddressBtn.classList.remove('ready')
    })
}

// Billing Address Verification for Add New Address
bAddressBtn.addEventListener('click', e => {
    e.preventDefault();

    if (bAddressBtn.classList.contains('add')) {
        bAddressBtn.classList.replace('add', 'save')
        bAddressBtn.innerHTML = 'Use this address'
        bAddressBtn.type = 'submit'
        bAddressForm.classList.remove('hidden')
        for (let i = 0; i < bAddressInputs.length; i++) {
            bAddressInputs[i].removeAttribute('readonly')
        }
    } else {
        for (let i = 0; i < bAddressInputs.length; i++) {
            if (!bAddressInputs[i].value) {
                billConfirmMsg.innerHTML = "Please fill in missing fields."
                return;
            }
        }

        if (!bZipMsg.innerHTML == "") {
            billConfirmMsg.innerHTML = "Please check your zip code."
        } else {
            billConfirmMsg.innerHTML = ""
            bAddressBtn.type = "button"
            bAddressBtn.classList.replace("save", "add")
            bAddressBtn.classList.add('ready')
            bAddressBtn.innerHTML = 'Use different address'
            billChosen = null;

            for (let i = 0; i < bAddressInputs.length; i++) {
                bAddressInputs[i].setAttribute('readonly', 'readonly')
            }

            for (let i = 0; i < availableBills.length; i++) {
                availableBills[i].classList.remove('peer-checked:border-accentPink', 'peer-checked:border-4')
            }

            for (let i = 0; i < billRadios.length; i++) {
                billRadios[i].checked = false
            }
        }
    }
})

// Review and Pay OR Place Order
continueBtn.addEventListener('click', e => {
    e.preventDefault();

    // Confirming Shipping/Billing Information for "Review and Pay"
    if (continueBtn.classList.contains('continue')) {
        for (let i = 0; i < shipRadios.length; i++) {
            if (shipRadios[i].checked) {
                shipChosen = shipRadios[i].value
            }
        }

        for (let i = 0; i < billRadios.length; i++) {
            if (billRadios[i].checked) {
                billChosen = billRadios[i].value
            }
        }

        if (!shipChosen && !sAddressBtn.classList.contains('ready')) {
            continueMsg.innerHTML = "Please select a shipping address."
        } else if (!billChosen && !bAddressBtn.classList.contains('ready')) {
            continueMsg.innerHTML = "Please select a billing address."
        } else { // All is good, continue to payment section
            document.body.scrollIntoView();
            continueDiv.classList.remove('place-items-center')
            continueMsg.classList.remove('text-center')
            addresses.classList.add('hidden')
            payment.classList.remove('hidden')
            continueMsg.innerHTML = ""
            continueBtn.classList.replace('continue', 'placeOrder')
            continueBtn.innerHTML = "Place Order"
        }
    } else {
        // Payment Field Verification for "Place Order"
        for (let i = 0; i < paymentInputs.length; i++) {
            if (!paymentInputs[i].value) {
                continueMsg.innerHTML = "Please fill in all fields."
                return;
            }
        }

        if (secCode.value.length < 3 || ccNumber.value.length != 19) {
            continueMsg.innerHTML = "Please check your card details."
        } else { // All is good, post all information and clear the cart
            if (sSaveAddr.checked) {
                // Post the shipping address to the addresses table if Save Address is checked
                var postRequest = new XMLHttpRequest();
                var url = './php/_accountDetails.php';
                postRequest.open('POST', url, true);
                postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                var postDetails = {
                    firstName: sFirstName.value,
                    lastName: sLastName.value,
                    company: sCompany.value,
                    address1: sAddress.value,
                    address2: sAddress2.value,
                    city: sCity.value,
                    state: sState.options[sState.selectedIndex].text,
                    stateAbbr: sState.value,
                    zip: sZip.value
                }
                postRequest.send(`newAddr=${JSON.stringify(postDetails)}`);
            }

            // Post the userID, date, shipMethod, promoCode, promoDiscount, subtotal, shipCost, tax, total to the orders table
            money_info.checkout = true
            updateSummary()
            var postdata = {
                method: '',
                promo: promoCode.innerText.replaceAll(/[()]/g, ''),
                discount: money_info.discount,
                sub: money_info.subtotal,
                shipCost: money_info.shipping,
                tax: money_info.tax,
                total: money_info.total
            }

            if (money_info.express) {
                postdata.method = 'Express'
            } else {
                postdata.method = 'Standard'
            }

            var postRequest = new XMLHttpRequest();
            var url = './php/wishandcart.php';
            postRequest.open('POST', url, true);
            postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            postRequest.onreadystatechange = function () {
                if (postRequest.readyState == 4 && postRequest.status == 200) {
                    money_info.orderid = Number(postRequest.responseText)
                    updateSummary()
                    window.location = "orderConfirmation"
                }
            }
            postRequest.send(`orderConfirm&orderData=${JSON.stringify(postdata)}`);
        }
    }
})

goBack.addEventListener('click', e => {
    e.preventDefault();

    addresses.classList.remove('hidden')
    payment.classList.add('hidden')
    continueDiv.classList.add('place-items-center')
    continueMsg.classList.add('text-center')
    continueMsg.innerHTML = ""
    continueBtn.classList.replace('placeOrder', 'continue')
    continueBtn.innerHTML = "Review and Pay"
})