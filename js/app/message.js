/**
 * Message object
 * @param {string} content
 * @param {int} hideTimeout
 * @returns {Message}
 */
var Message = function(content, hideTimeout) {
    this.content = content || '';
    this.hideTimeout = hideTimeout || 3000;
};

var MessageEl = function() {
    var el = null;
    var elTag = 'nav';
    var elId = 'message';
    var timeoutAttribute = 'js-timeout';

    init = function() {
        el = document.getElementById(elId);
        if (!el) {
            el = document.createElement(elTag);
            el.id = elId;
            el.innerText = '';
            document.body.appendChild(el);
        }
    };

    /**
     * Hide the message after the timeout which is defined in its 'js-timeout' attribute.
     * @returns {undefined}
     */
    this.hide = function() {
        var hideTimeout = parseInt(el.getAttribute(timeoutAttribute));
        el.removeAttribute(timeoutAttribute);
        setTimeout(function() {
            el.style.display = 'none';
            el.innerText = null;
        }, hideTimeout || 3000);
    };

    /**
     * Add a message in the message stack with a number of milliseconds.
     * @param {Message} message The message
     * @returns {undefined}
     */
    this.display = function(message) {
        if (!message || !message.content.length)
            return;
        if (el.innerText && el.innerText.length) {
            el.innerText += "\n";
        }
        el.style.display = 'block';
        el.innerText += message.content;
        var currentTimeout = parseInt(el.getAttribute(timeoutAttribute)) || 0;
        el.setAttribute(timeoutAttribute, currentTimeout + message.hideTimeout);
    };

    /**
     * Add a message in the message stack and automatically display the message stack.
     * @param {Message} message The message
     * @returns {undefined}
     */
    this.displayHiding = function(message) {
        this.display(message);
        this.hide();
    };

    init();
};