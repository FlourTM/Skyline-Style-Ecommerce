// Message function
var default_duration = 3 // How many seconds it takes for the message to disappear
var timer
function message(location, text, duration) {
    var dur = default_duration // How many seconds
    location.innerHTML = text
    if (duration) {
        dur = duration
    }
    clearInterval(timer)
    timer = setInterval(function () {
        location.innerHTML = ''
    }, dur * 1000)
}