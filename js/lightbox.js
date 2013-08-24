var lightbox = {
    isInitialized : false,
    isHidden : true,
    element : null,
    box : null,
    topBar : null,
    closeButton : null,

    init : function() {
	if (!this.isInitialized) {
	    this.element = document.getElementById("lightbox");
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
        lightboxElement.className = '';
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
	var lightboxElement = lightbox.getBox();
	if (width > totalWidth - 20) {
	    width = totalWidth - 20;
	}
	var margin = (totalWidth - width - 20)/2; // 20 is the padding
	lightboxElement.style.marginLeft = margin + "px";
	lightboxElement.style.marginRight = margin + "px";
	lightboxElement.style.width = width + "px";
    },

    setHeight : function(height) {
        var totalHeight = window.innerHeight;
	var lightboxElement = lightbox.getBox();
        if (height > totalHeight - 20) {
            height = totalHeight - 20;
        }
	lightboxElement.style.top = (totalHeight - height - 20)/2 + "px"; // 20 is the padding
	lightboxElement.style.height = height + "px";
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

        height = window.innerHeight * 0.8;
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
        width = width || document.width;
        height = height || (width * 9/16);
        container.className =  'bande-annonce-lightbox';

        var iframe = document.createElement('iframe');
        url = url.replace(/&amp;/g,"&");
        url = url.replace(/&lt;/g,"<");
        url = url.replace(/&gt;/g,">");
        url = url.replace(/&quot;/g,"\"");
        iframe.src = url;
        iframe.width = width - 24; // 24 = padding-top + padding-bottom + 4 for the iframe
        iframe.height = height;

        container.appendChild(iframe);
    }

    box.appendChild(container);
    lightbox.addHideEvents();
    lightbox.display();

    lightbox.setWidth(width);
    lightbox.setHeight(container.clientHeight);
}

