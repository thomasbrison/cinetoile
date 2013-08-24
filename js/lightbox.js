var lightbox = {
    isInitialized : false,
    isHidden : true,
    element : null,
    box : null,
    topBar : null,
    closeButton : null,
    offset : null,

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
        lightbox.offset = {  // corresponds to the padding + the border
            left : 12,
            top : 12,
            right : 12,
            bottom : 12
        };
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

	lightbox.box = boxElement;

	lightboxElement.appendChild(boxElement);
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
        var totalWidth = document.width;
        var totalOffset = lightbox.offset.left + lightbox.offset.right;
	var boxElement = lightbox.getBox();
	if (width > totalWidth - totalOffset) {
	    width = totalWidth - totalOffset;
	}
	var margin = (totalWidth - width - totalOffset)/2;
	boxElement.style.marginLeft = margin + "px";
	boxElement.style.marginRight = margin + "px";
	boxElement.style.width = width + "px";
    },

    setHeight : function(height) {
        var totalHeight = window.innerHeight;
        var totalOffset = lightbox.offset.top + lightbox.offset.bottom;
	var boxElement = lightbox.getBox();
        if (height > totalHeight - totalOffset) {
            height = totalHeight - totalOffset;
        }
	boxElement.style.top = (totalHeight - height - totalOffset)/2 + "px";
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

        width = document.width * 0.7;
    } else {
        var imageLightbox = document.createElement('img');
        imageLightbox.src = cheminAffiche;

        box.appendChild(imageLightbox);

        height = window.innerHeight * 0.9;
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

    lightbox.setWidth(document.width * 0.7);
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

        width = document.width * 0.7;
    } else {
        width = width || Math.min(document.width, (window.innerHeight - lightbox.offset.top - lightbox.offset.bottom) * 16/9);
        height = height || (width * 9/16);
        container.className =  'bande-annonce-lightbox';

        var iframe = document.createElement('iframe');
        url = url.replace(/&amp;/g,"&");
        url = url.replace(/&lt;/g,"<");
        url = url.replace(/&gt;/g,">");
        url = url.replace(/&quot;/g,"\"");
        iframe.src = url;
        iframe.width = width - lightbox.offset.left - lightbox.offset.right;
        iframe.height = height - lightbox.offset.top - lightbox.offset.bottom;

        container.appendChild(iframe);
    }

    box.appendChild(container);
    lightbox.addHideEvents();
    lightbox.display();

    lightbox.setWidth(width);
    lightbox.setHeight(container.clientHeight);
}

