// Switching Navigation Panels :D
const accountNav = document.querySelectorAll('.accountNav'),
    accountSection = document.querySelectorAll('.section')

var currentNav
accountNav.forEach(button => {
    button.addEventListener('click', e => {
        if (currentNav != button.id) {
            currentNav = button.id

            accountNav.forEach(btns => {
                if (btns.id != button.id) {
                    btns.classList.remove('active')
                }
            })
            button.classList.add('active')

            accountSection.forEach(section => {
                if (!button.id.match(section.classList[1])) {
                    section.classList.add('hidden')
                } else {
                    section.classList.remove('hidden')
                }
            })
        }
    })
})

// Logs out the user
const logoutButton = document.getElementById('logout')

logoutButton.onclick = function () {
    var postRequest = new XMLHttpRequest();
    var url = './php/_account.php';
    sessionStorage.removeItem("userid")
    window.location = 'index'
    postRequest.open('POST', url, true);
    postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    postRequest.send('logout')
}

// Account Information
const btnEditDetail = document.getElementById('edit'),
    btnChangePass = document.getElementById('change'),
    detailsForm = document.getElementById('accountForm'),
    passForm = document.getElementById('passForm'),
    confirmMsg = document.getElementById('confirm-msg'),
    fNameMsg = document.getElementById('fNameMsg'),
    lNameMsg = document.getElementById('lNameMsg'),
    emailMsg = document.getElementById('emailMsg'),
    phoneMsg = document.getElementById('phoneMsg')
var validEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var validPhone = /^\d{10}$/;
var validPass = /^(?=.*\d)(?=.*[a-z]).{8,20}$/;
var editDetails = document.querySelectorAll('.input1'),
    firstName = document.getElementById('fName'),
    lastName = document.getElementById('lName'),
    emailAdd = document.getElementById('email'),
    phoneNum = document.getElementById('phone'),
    currentPass = document.getElementById('current'),
    newPass = document.getElementById('new'),
    confirmPass = document.getElementById('confirm');

// Edit Account Details
btnEditDetail.addEventListener('click', e => {
    var postRequest = new XMLHttpRequest();
    var url = './php/_accountDetails.php';
    var params = [];
    e.preventDefault();

    if (btnEditDetail.classList.contains('edit')) {
        btnEditDetail.classList.replace('edit', 'save')
        btnEditDetail.innerHTML = 'Save Details'
        btnChangePass.classList.replace('change', 'cancelInfo')
        btnChangePass.innerHTML = 'Cancel'
        btnEditDetail.type = "submit"
        confirmMsg.innerHTML = ""

        for (var i = 0; i < editDetails.length; i++) {
            editDetails[i].removeAttribute('readonly')
            editDetails[i].classList.add('border-b', 'border-LMtext1', 'dark:border-DMtext1')
        }

        firstName.addEventListener('input', () => {
            if (firstName.value.length == 0) {
                fNameMsg.innerHTML = "Names cannot be empty."
            } else {
                fNameMsg.innerHTML = ""
            }
        })
        lastName.addEventListener('input', () => {
            if (lastName.value.length == 0) {
                lNameMsg.innerHTML = "Names cannot be empty."
            } else {
                lNameMsg.innerHTML = ""
            }
        })
        emailAdd.addEventListener('input', () => {
            if (!emailAdd.value.match(validEmail)) {
                emailMsg.innerHTML = "Please check your email."
            } else {
                emailMsg.innerHTML = ""
            }
        })
        phoneNum.addEventListener('input', () => {
            if (phoneNum.value.length != 0 && !phoneNum.value.match(validPhone)) {
                phoneMsg.innerHTML = "Please check your phone number."
            } else {
                phoneMsg.innerHTML = ""
            }
        })
    } else if (btnEditDetail.classList.contains('save')) {
        if (!fNameMsg.innerHTML == "" || !lNameMsg.innerHTML == "" || !emailMsg.innerHTML == "" || !phoneMsg.innerHTML == "") {
            confirmMsg.innerHTML = "Please fix all fields."
        } else if (emailAdd.value == emailAdd.placeholder && phoneNum.value == phoneNum.placeholder &&
            firstName.value == firstName.placeholder && lastName.value == lastName.placeholder) {
            btnChangePass.classList.replace("cancelInfo", "change")
            btnChangePass.innerHTML = 'Change Password'
            btnEditDetail.classList.replace('save', 'edit')
            btnEditDetail.innerHTML = "Edit Details"
            btnChangePass.type = "button"

            message(confirmMsg, "No changes made.")

            for (var i = 0; i < editDetails.length; i++) {
                editDetails[i].setAttribute('readonly', 'readonly')
                editDetails[i].classList.remove('border-b', 'border-LMtext1', 'dark:border-DMtext1')
            }
        } else {
            postRequest.onreadystatechange = function () {
                if (postRequest.readyState == 4 && postRequest.status == 200) {
                    confirmMsg.innerHTML = postRequest.responseText
                    if (postRequest.responseText.includes("saved")) {
                        btnChangePass.classList.replace("cancelInfo", "change")
                        btnChangePass.innerHTML = 'Change Password'
                        btnEditDetail.classList.replace('save', 'edit')
                        btnEditDetail.innerHTML = "Edit Details"
                        btnChangePass.type = "button"
                        emailAdd.placeholder = emailAdd.value
                        phoneNum.placeholder = phoneNum.value
                        firstName.placeholder = firstName.value
                        lastName.placeholder = lastName.value

                        for (var i = 0; i < editDetails.length; i++) {
                            editDetails[i].setAttribute('readonly', 'readonly')
                            editDetails[i].classList.remove('border-b', 'border-LMtext1', 'dark:border-DMtext1')
                        }
                    }
                }
            }
            for (var i = 0; i < editDetails.length; i++) {
                params.push(editDetails[i].id + '=' + editDetails[i].value + '&')
            }

            postRequest.open('POST', url, true);
            postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var tostr = params.toString();
            postRequest.send(tostr.replaceAll(',', ''));
        }
    } else if (btnEditDetail.classList.contains('change')) {
        if (newPass.value != confirmPass.value) {
            confirmMsg.innerHTML = "Passwords do not match."
        } else if (!newPass.value.match(validPass) && !newPass.value == "") {
            confirmMsg.innerHTML = "Password must contain 1 letter, 1 number, and be between 8-20 characters."
        } else if (newPass.value == "" && confirmPass.value == "") {
            confirmMsg.innerHTML = "Password cannot be empty."
        } else {
            postRequest.open('POST', url, true);

            postRequest.onreadystatechange = function () {
                if (postRequest.readyState == 4 && postRequest.status == 200) {
                    confirmMsg.innerHTML = postRequest.responseText
                    if (postRequest.responseText.includes("changed")) {
                        btnChangePass.classList.replace("savePW", "change")
                        btnChangePass.innerHTML = 'Change Password'
                        btnChangePass.type = "button"

                        passForm.classList.add('hidden')
                        detailsForm.classList.remove('hidden')
                        message(confirmMsg, "Password successfully changed.")
                        passForm.reset();
                    }
                }
            }

            postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            postRequest.send(`password=${currentPass.value}&newpass=${newPass.value}`);
        }
    }
})

// Change Password Opening & Cancel Buttons
btnChangePass.addEventListener('click', e => {
    e.preventDefault();

    if (btnChangePass.classList.contains('change')) {
        btnChangePass.classList.replace("change", "cancelPW")
        btnEditDetail.classList.replace('edit', 'change')
        btnEditDetail.innerHTML = "Save Password"
        btnChangePass.innerHTML = 'Cancel'
        btnChangePass.type = "submit"

        detailsForm.classList.add('hidden')
        passForm.classList.remove('hidden')
        confirmMsg.innerHTML = ""
    } else if (btnChangePass.classList.contains('cancelPW')) {
        btnChangePass.classList.replace("cancelPW", "change")
        btnChangePass.innerHTML = 'Change Password'
        btnEditDetail.classList.replace('change', 'edit')
        btnEditDetail.innerHTML = "Edit Details"
        btnChangePass.type = "button"

        btnEditDetail.classList.remove('hidden')
        passForm.classList.add('hidden')
        detailsForm.classList.remove('hidden')

        confirmMsg.innerHTML = ""
    } else if (btnChangePass.classList.contains('cancelInfo')) {
        btnChangePass.classList.replace("cancelInfo", "change")
        btnChangePass.innerHTML = 'Change Password'
        btnEditDetail.classList.replace('save', 'edit')
        btnEditDetail.innerHTML = "Edit Details"
        btnChangePass.type = "button"

        for (var i = 0; i < editDetails.length; i++) {
            editDetails[i].setAttribute('readonly', 'readonly')
            editDetails[i].classList.remove('border-b', 'border-LMtext1', 'dark:border-DMtext1')
        }

        confirmMsg.innerHTML = ""
        fNameMsg.innerHTML = ""
        lNameMsg.innerHTML = ""
        emailMsg.innerHTML = ""
        phoneMsg.innerHTML = ""

        emailAdd.value = emailAdd.placeholder
        phoneNum.value = phoneNum.placeholder
        firstName.value = firstName.placeholder
        lastName.value = lastName.placeholder
    }
})

// Address Information
const addressBtn = document.getElementById('addressBtn'),
    cancelAddr = document.getElementById('cancelAddr'),
    addressForm = document.getElementById('addressForm'),
    addressInfo = document.getElementById('addressInfo'),
    addressText = document.getElementById('addressText'),
    zipMsg = document.getElementById('zipMsg')

var validZip = /(^\d{5}$)|(^\d{5}-\d{4}$)/;
var addrDetails = document.querySelectorAll('.input2'),
    zip = document.getElementById('zip')

// Add Address
$(document).ready(function () {
    $(addressBtn).click(function () {
        if (addressBtn.classList.contains('add')) {
            addressBtn.classList.replace("add", "save")
            addressBtn.innerHTML = 'Save Address'
            addressBtn.type = "submit"

            addressInfo.classList.add('hidden')
            addressForm.classList.remove('hidden')
            cancelAddr.classList.remove('hidden')
            confirmMsg.innerHTML = ""

            // Zip Code Verification
            zip.addEventListener('input', () => {
                if (!zip.value.match(validZip)) {
                    zipMsg.innerHTML = "Please check your zip code."
                } else {
                    zipMsg.innerHTML = ""
                }
            })
        } else {
            for (let i = 0; i < addrDetails.length; i++) {
                if (!addrDetails[i].value) {
                    confirmMsg.innerHTML = "Please fill in missing fields."
                    return;
                }
            }

            if (!zipMsg.innerHTML == "") {
                confirmMsg.innerHTML = "Please check your zip code."
            } else {
                var postRequest = new XMLHttpRequest();
                var url = 'php/_accountDetails.php';

                postRequest.open('POST', url, true);

                postRequest.onreadystatechange = function () {
                    if (postRequest.readyState == 4 && postRequest.status == 200) {
                        confirmMsg.innerHTML = postRequest.responseText
                        if (postRequest.responseText.includes("saved")) {
                            addressBtn.classList.replace("save", "add")
                            addressBtn.innerHTML = 'Add New Address'
                            addressBtn.type = "button"

                            addressInfo.classList.remove('hidden')
                            addressForm.classList.add('hidden')
                            addressForm.reset()
                            cancelAddr.classList.add('hidden')
                            message(confirmMsg, "Address saved successfully.")
                            for (let i = 0; i < addrDetails.length; i++) {
                                addrDetails[i].placeholder = addrDetails[i].value
                            }
                        }
                    }
                }

                var postDetails = {
                    firstName: document.getElementById('firstName').value,
                    lastName: document.getElementById('lastName').value,
                    company: document.getElementById('company').value,
                    address1: document.getElementById('address1').value,
                    address2: document.getElementById('address2').value,
                    city: document.getElementById('city').value,
                    state: document.getElementById('state').options[state.selectedIndex].text,
                    stateAbbr: document.getElementById('state').value,
                    zip: zip.value
                }
                document.getElementById('addrContainer').innerHTML = ''
                postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                postRequest.send(`newAddr=${JSON.stringify(postDetails)}`);
                setTimeout(200)
                $("#addrContainer").load('php/loadAddr.php')
            }
        }
    })
})

// Remove Address
$(document).ready(function () {
    // Add click handler to parent element
    $('#addrContainer').on('click', '.deleteAddr', function () {
        var postRequest = new XMLHttpRequest();
        var url = './php/_accountDetails.php';
        message(confirmMsg, 'Address removed.')
        this.closest('#addrbox').remove()
        postRequest.open('POST', url, true);
        postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        postRequest.send(`addremove=${this.id}`);
        setTimeout(200)
        $("#addrContainer").load('php/loadAddr.php')
    });
});

// Cancel Address
cancelAddr.addEventListener('click', e => {
    addressBtn.classList.replace("save", "add")
    addressBtn.innerHTML = 'Add New Address'
    addressBtn.type = "button"

    addressInfo.classList.remove('hidden')
    addressForm.classList.add('hidden')
    addressForm.reset()
    cancelAddr.classList.add('hidden')
    confirmMsg.innerHTML = ""
})