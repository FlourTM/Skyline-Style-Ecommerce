//  Uses a GET PHP function to grab the 'footer.html' file and place it in every page
function includeHTML() {
    var doc = document.getElementById('footer-ph')
    var grab = doc.getAttribute('w3-include-html')

    if (grab) {
        var http = new XMLHttpRequest();
        http.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    doc.innerHTML = this.responseText;
                }
                if (this.status == 404) {
                    doc.innerHTML = "Page not found.";
                }
                doc.removeAttribute('w3-include-html')
                includeHTML();
            }
        }
        http.open('GET', grab, true)
        http.send()
        return;
    }
}
includeHTML();