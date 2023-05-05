const confirmMsg = document.getElementById('confirm-msg'),
    addCart = document.getElementById('addCart'),
    addWishlist = document.getElementById('addWishlist'),
    sizeMenu = document.querySelector('.sizeMenu'),
    details = document.querySelector('.itemdetails')

document.addEventListener('DOMContentLoaded', function () {
    // Add to Cart
    addCart.addEventListener('click', () => {
        var postRequest = new XMLHttpRequest();
        var url = './php/wishandcart.php';
        postRequest.open('POST', url, true);
        postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        if (!sessionStorage.getItem('userid')) {
            message(confirmMsg, 'Must be logged in to add to cart!')
        } else {
            if (sizeMenu) {
                if (sizeMenu.value) {
                    postRequest.onreadystatechange = function () {
                        if (postRequest.readyState == 4 && postRequest.status == 200) {
                           message(confirmMsg, postRequest.responseText)
                        }
                    }
                    postRequest.send(`cartAdd&itemID=${details.id}&itemSize=${sizeMenu.value}&itemQuantity=1`);
                } else {
                    message(confirmMsg, 'Please select a size!')
                }
            } else {
                postRequest.onreadystatechange = function () {
                    if (postRequest.readyState == 4 && postRequest.status == 200) {
                       message(confirmMsg, postRequest.responseText)
                    }
                }
                postRequest.send(`cartAdd&itemID=${details.id}&itemQuantity=1`);
            }
        }
    })

    // Add or Remove from Wishlist
    addWishlist.addEventListener('click', () => {
        var postRequest = new XMLHttpRequest();
        var url = './php/wishandcart.php';
        postRequest.open('POST', url, true);
        postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        if (!sessionStorage.getItem('userid')) {
            message(confirmMsg, 'Must be logged in to add to wishlist!')
        } else {
            if (addWishlist.innerHTML.includes('Add')) {
                message(confirmMsg, 'Successfully added to wishlist!')
                addWishlist.innerHTML = 'Remove from Wishlist'
                postRequest.send(`wlAdd&itemID=${details.id}`);
            } else {
                message(confirmMsg, 'Successfully removed from wishlist!')
                addWishlist.innerHTML = 'Add to Wishlist'
                postRequest.send(`wlRemove&itemID=${details.id}`);
            }
        }
    })
});