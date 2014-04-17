function onload() {
    hideMessage();
}

function displayMessage(message, hideTimeout) {
    var msgEl = document.getElementById('message');
    if (!msgEl) {
        msgEl = document.createElement('nav');
        msgEl.id = "message";
        document.body.appendChild(msgEl);
    } else {
        msgEl.style.display = 'block';
    }
    msgEl.innerText = message;
    msgEl.setAttribute('js-timeout', hideTimeout);
}

function hideMessage() {
    var msgEl = document.getElementById('message');
    if (msgEl) {
        var hideTimeout = msgEl.getAttribute('js-timeout');
        setTimeout(function() {
            msgEl.style.display = 'none';
        }, hideTimeout || 3000);
    }
}
