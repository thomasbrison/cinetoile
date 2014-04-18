var Message = function() {
    var elTag = 'nav';
    var elId = 'message';
    var timeoutAttribute = 'js-timeout';

    init = function() {
        msgEl = document.getElementById(elId);
        if (!msgEl) {
            msgEl = document.createElement(elTag);
            msgEl.id = elId;
            msgEl.innerText = '';
            document.body.appendChild(msgEl);
        }
    };

    /**
     * Hide the message after the timeout which is defined in its 'js-timeout' attribute.
     * @returns {undefined}
     */
    this.hide = function() {
        var hideTimeout = parseInt(msgEl.getAttribute(timeoutAttribute));
        msgEl.removeAttribute(timeoutAttribute);
        setTimeout(function() {
            msgEl.style.display = 'none';
            msgEl.innerText = null;
        }, hideTimeout || 3000);
    };

    /**
     * Add a message in the message stack with a number of milliseconds.
     * @param {string} message The message
     * @param {int} hideTimeout Time in ms the message should be displayed
     * @returns {undefined}
     */
    this.display = function(message, hideTimeout) {
        if (!message || !message.length)
            return;
        if (msgEl.innerText && msgEl.innerText.length) {
            msgEl.innerText += "\n";
        }
        msgEl.style.display = 'block';
        msgEl.innerText += message;
        var currentTimeout = parseInt(msgEl.getAttribute(timeoutAttribute)) || 0;
        hideTimeout = hideTimeout || 3000;
        msgEl.setAttribute(timeoutAttribute, currentTimeout + hideTimeout);
    };

    /**
     * Add a message in the message stack and automatically display the message stack.
     * @param {string} message The message
     * @param {int} hideTimeout Time in ms the message should be displayed
     * @returns {undefined}
     */
    this.displayHiding = function(message, hideTimeout) {
        display(message, hideTimeout);
        hide();
    };

    init();
};