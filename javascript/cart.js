const removeCart = document.querySelectorAll('.removeCart'),
    addWishlist = document.querySelectorAll('.addWishlist'),
    quantity = document.querySelectorAll('.quantity'),
    price = document.querySelectorAll('#price'),
    subtotal = document.getElementById('subtotal'),
    shipping = document.getElementById('shipping'),
    tax = document.getElementById('tax'),
    total = document.getElementById('total')

var money_info = {
    subtotal: 0,
    shipping: 0,
    standard: 4.99,
    free_ship: false,
    express: false,
    tax: 0,
    tax_rate: 0.07,
    discount: 0,
    code: "",
    total: 0,
    orderid:0,
    checkout: false
}

window.onload = function () {
    // Update price upon loading
    var tax_rate = 0.07;
    var ship_price = 4.99;
    var free_ship = 65;

    function updateSummary() {
        //Summary Page Updating
        const details = document.querySelectorAll('#details')
        var st_val = 0;
        for (let i = 0; i < details.length; i++) {
            var value = Number(details[i].getAttribute('itemPrice') * details[i].querySelector('.quantity').value)
            st_val = st_val += value
        }

        if (st_val < free_ship) {
            money_info.shipping = ship_price
            shipping.innerHTML = `$${money_info.shipping}`
            total.innerHTML = `$${(st_val + (st_val * tax_rate) + ship_price).toFixed(2)}`
            money_info.free_ship = false
        } else {
            money_info.shipping = 0
            money_info.free_ship = true
            shipping.innerHTML = 'FREE'
            total.innerHTML = `$${(st_val + (st_val * tax_rate)).toFixed(2)}`
        }
        money_info.subtotal = Number(st_val.toFixed(2))
        money_info.tax = Number((st_val * tax_rate).toFixed(2))

        subtotal.innerHTML = `$${money_info.subtotal.toFixed(2)}`
        tax.innerHTML = `$${money_info.tax.toFixed(2)}`

        localStorage['money_info'] = JSON.stringify(money_info)
        return st_val
    }

    updateSummary()

    // Individual Price
    price.forEach(e => {
        var price = e.closest('#details').getAttribute('itemPrice')
        var value = e.closest('#details').querySelector('.quantity').value
        e.innerHTML = `$${(price * value).toFixed(2)}`
    })

    // Remove from Cart
    removeCart.forEach(btn => {
        btn.addEventListener('click', e => {
            var postRequest = new XMLHttpRequest();
            var url = './php/wishandcart.php';
            var id = btn.closest('#details').getAttribute('itemID')
            var size = btn.closest('#details').getAttribute('itemSize');
            btn.closest('#details').remove()
            if(updateSummary() == 0){
                location.reload()
            }
            postRequest.open('POST', url, true);
            postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            postRequest.send(`cartRemove&itemID=${id}&itemQuantity=0&itemSize=${size}`);
        })
    })

    // Update Quantity
    quantity.forEach(btn => {
        btn.onchange = () => {
            // Post Request Variables
            var postRequest = new XMLHttpRequest();
            var url = './php/wishandcart.php';
            var id = btn.closest('#details').getAttribute('itemID')
            var size = btn.closest('#details').getAttribute('itemSize');

            postRequest.open('POST', url, true);
            postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            postRequest.send(`cartRemove&itemID=${id}&itemQuantity=${btn.value}&itemSize=${size}`);

            // Price Updating
            var price = btn.closest('#details').getAttribute('itemPrice')
            var value = btn.closest('#details').querySelector('.quantity').value
            var element = btn.closest('#details').querySelector('#price')
            element.innerHTML = `$${(price * value).toFixed(2)}`
            updateSummary()
        };
    })

    // Add or Remove from Wishlist
    addWishlist.forEach(btn => {
        btn.addEventListener('click', e => {
            var postRequest = new XMLHttpRequest();
            var url = './php/wishandcart.php';
            var id = btn.closest('#details').getAttribute('itemID')
            var confirmMsg = btn.closest('#details').querySelector('#confirm-msg')
            postRequest.open('POST', url, true);
            postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            if (btn.innerHTML.includes('Add')) {
                btn.innerHTML = 'Remove from Wishlist'
                message(confirmMsg, "Successfully added to wishlist!")
                postRequest.send(`wlAdd&itemID=${id}`);
            } else {
                btn.innerHTML = 'Add to Wishlist'
                message(confirmMsg,"Successfully removed from wishlist!")
                postRequest.send(`wlRemove&itemID=${id}`);
            }
        })
    })
}