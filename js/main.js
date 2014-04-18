function onload() {
    // Hide the messages that are in the message stack after the timeout that is defined by the 'js-timeout' attribute of the message element.
    hideMessage();
}

/**
 * Hide the message after the timeout which is defined in its 'js-timeout' attribute.
 * @returns {undefined}
 */
function hideMessage() {
    var msgEl = document.getElementById('message');
    if (msgEl) {
        var hideTimeout = parseInt(msgEl.getAttribute('js-timeout'));
        setTimeout(function() {
            msgEl.style.display = 'none';
        }, hideTimeout || 3000);
    }
}

/**
 * Add a message in the message stack with a number of milliseconds.
 * @param {string} message The message
 * @param {int} hideTimeout Time in ms the message should be displayed
 * @returns {undefined}
 */
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
    var currentTimeout = parseInt(msgEl.getAttribute('js-timeout')) || 0;
    hideTimeout = hideTimeout || 3000;
    msgEl.setAttribute('js-timeout', currentTimeout + hideTimeout);
}

/**
 * Add a message in the message stack and automatically display the message stack.
 * @param {string} message The message
 * @param {int} hideTimeout Time in ms the message should be displayed
 * @returns {undefined}
 */
function displayHidingMessage(message, hideTimeout) {
    displayMessage(message, hideTimeout);
    hideMessage();
}
