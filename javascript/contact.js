const sendButton = document.getElementById('contact-btn')
const confirmMsg = document.getElementById('confirm-msg')
var postRequest = new XMLHttpRequest();
var url = './php/_contact.php';
var params = [];

sendButton.addEventListener('click', e => {
    e.preventDefault();

    var name = document.getElementById('name');
    var emailVerify = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var email = document.getElementById('email');
    var userText = document.getElementById('content');

    // Verifies that the email is in the correct format. 
    // If all is complete, it will send the content 
    // information to the database.
    if (name.value == 0 || email.value == 0 || userText.value == 0) {
        confirmMsg.innerHTML = "Please fill in all fields."
    } else if (!email.value.match(emailVerify)) {
        confirmMsg.innerHTML = "Email is in wrong format."
    } else {
        confirmMsg.innerHTML = "Message sent successfully."
        postRequest.open('POST', url, true);
        postRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

        postRequest.send(`name=${name.value}&email=${email.value}&content=${userText.value}`);
        document.getElementById("contactForm").reset();
    }
})