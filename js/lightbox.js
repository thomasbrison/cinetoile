/*
 * Lightbox servant à afficher les affiches / synopsis / bandes-annonces
 */

var lightbox = {
    isInitialized : false,
    isHidden : true,
    element : null,
    box : null,
    topBar : null,
    closeButton : null,
    offset : null,
    maxWidth : 0,
    maxHeight : 0,

    init : function() {
	if (!this.isInitialized) {
	    this.addElement();
	    this.addTopBar();
	    this.addBox();
	    this.isInitialized = true;
	 } else {
	    this.getBox().innerHTML = "";
	 }
    },

    display : function() {
        var lightboxElement = lightbox.getElement();
        lightboxElement.className = 'visible';
        this.isHidden = false;
    },

    hide : function(event) {
        var lightboxElement = lightbox.getElement();
        var boxElement = lightbox.getBox();
        var topBar = lightbox.getTopBar();
	var closeButton = lightbox.getCloseButton();

        if ((event && (event.target !== lightboxElement) && (event.target !== closeButton)  && (event.target !== topBar))) return;

	boxElement.innerHTML = "";
        boxElement.setAttribute('style', "");
        lightboxElement.className = 'hidden';
        this.isHidden = true;
    },

    getElement : function() {
	return this.element;
    },

    getBox : function() {
	return this.box;
    },

    getTopBar : function() {
	return this.topBar;
    },

    getCloseButton : function() {
	return this.closeButton;
    },

    addElement : function() {
        var lightboxElement = document.createElement('div');
        lightboxElement.id = "lightbox";
        document.getElementById('main').appendChild(lightboxElement);
        lightbox.element = lightboxElement;
    },

    addTopBar : function() {
	var lightboxElement = lightbox.getElement();
	var barElement = document.createElement('div');
	var closeButtonElement = document.createElement('div');

	barElement.className = 'lightbox-top-bar';
	closeButtonElement.className = 'close';

        lightbox.topBar = barElement;
	lightbox.closeButton = closeButtonElement;

	barElement.appendChild(closeButtonElement);
	lightboxElement.appendChild(barElement);
    },

    addBox : function() {
	var lightboxElement = lightbox.getElement();
	var boxElement = document.createElement('div');

	boxElement.className = 'lightbox-container';
        var boxStyle = window.getComputedStyle(boxElement);

	lightbox.box = boxElement;

	lightboxElement.appendChild(boxElement);

        // computes the offset which corresponds to the padding + the border
        function computeOffset(style, direction) {
            var padding = style.getPropertyValue('padding-' + direction);
            var borderWidth = style.getPropertyValue('border-' + direction + '-width');
            return parseFloat(padding.substring(0, padding.length - 2)) + parseFloat(borderWidth.substring(0, borderWidth.length - 2));
        }

        lightbox.offset = {
            left :  computeOffset(boxStyle, 'left'),
            top : computeOffset(boxStyle, 'top'),
            right : computeOffset(boxStyle, 'right'),
            bottom : computeOffset(boxStyle, 'bottom')
        };
        lightbox.maxWidth = document.documentElement.clientWidth - lightbox.offset.left - lightbox.offset.right;
        lightbox.maxHeight = document.documentElement.clientHeight - lightbox.offset.top - lightbox.offset.bottom;
    },

    addHideEvents : function() {
        lightbox.getElement().addEventListener('click', lightbox.hide, false);
        lightbox.getCloseButton().addEventListener('click', lightbox.hide, false);
        document.addEventListener('keyup', function(event) {
            // Touche echap
            if (event.keyCode === 27) {
                lightbox.hide();
            }
        }, false);
    },

    setWidth : function(width) {
	var boxElement = lightbox.getBox();
	if (width > lightbox.maxWidth) {
	    width = lightbox.maxWidth;
	}
	boxElement.style.width = width + "px";
    },

    setHeight : function(height) {
	var boxElement = lightbox.getBox();
        if (height > lightbox.maxHeight) {
            height = lightbox.maxHeight;
        }
	boxElement.style.top = (lightbox.maxHeight - height)/2 + "px";
	boxElement.style.height = height + "px";
    }
};

function afficheAffiche(el) {
    lightbox.init();
    var box = lightbox.getBox();
    var cheminAffiche = el.getAttribute('data-href');
    var width, height;

    if (!cheminAffiche || cheminAffiche === "") {
        var p = document.createElement('p');
        p.innerHTML = "L'affiche n'est actuellement pas disponible pour ce film.";

        box.appendChild(p);

        width = lightbox.maxWidth * 0.7;
    } else {
        var imageLightbox = document.createElement('img');
        imageLightbox.src = cheminAffiche;

        box.appendChild(imageLightbox);

        height = lightbox.maxHeight * 0.95;
        width = height * 3/4;
    }

    lightbox.addHideEvents();
    lightbox.display();

    if (p) {
        height = p.clientHeight;
    }
    lightbox.setWidth(width);
    lightbox.setHeight(height);
} 

function afficheSynopsis(el) {
    lightbox.init();
    var box = lightbox.getBox();
    var synopsis = el.getAttribute('data-synopsis');
    var block = document.createElement('blockquote');

    if (!synopsis || synopsis === "") {
        synopsis = "Le synopsis n'est actuellement pas disponible pour ce film.";
    } else {
        block.className = 'text-left white-spaces';
    }
    block.innerHTML = synopsis;

    box.appendChild(block);

    lightbox.addHideEvents();
    lightbox.display();

    lightbox.setWidth(lightbox.maxWidth * 0.7);
    lightbox.setHeight(block.clientHeight);
}

function afficheBandeAnnonce(el, width, height) {
    lightbox.init();
    var box = lightbox.getBox();
    var url = el.getAttribute('data-ba');
    var container = document.createElement('div');

    if (!url || url === "") {
        container.className = 'conteneur-lightbox';
        var block = document.createElement('p');
        block.innerHTML = "La bande-annonce n'est actuellement pas disponible pour ce film.";

        container.appendChild(block);

        width = lightbox.maxWidth * 0.7;
    } else {
        width = width || Math.min(lightbox.maxWidth, lightbox.maxHeight * 16/9);
        height = height || (width * 9/16);
        container.className =  'bande-annonce-lightbox';

        var iframe = document.createElement('iframe');
        url = url.replace(/&amp;/g,"&");
        url = url.replace(/&lt;/g,"<");
        url = url.replace(/&gt;/g,">");
        url = url.replace(/&quot;/g,"\"");
        iframe.src = url;
        iframe.width = width;
        iframe.height = height;

        container.appendChild(iframe);
    }

    box.appendChild(container);
    lightbox.addHideEvents();
    lightbox.display();

    lightbox.setWidth(width);
    lightbox.setHeight(container.clientHeight);
}
