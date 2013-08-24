var lightbox = {
    isInitialized : false,
    isHidden : true,
    element : null,
    box : null,
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
	var closeButton = lightbox.getCloseButton();

        if ((event && (event.target !== lightboxElement) && (event.target !== closeButton))) return;

	lightbox.getBox().innerHTML = "";
        lightboxElement.className = '';
        this.isHidden = true;
    },
    
    getElement : function() {
	return this.element;
    },

    getBox : function() {
	return this.box;
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

    setHeight : function(height) {
	var lightboxElement = lightbox.getBox();
	lightboxElement.style.top = (window.innerHeight - height)/2 - 10 + "px"; // 10 is the padding
	lightboxElement.style.height = height + "px";
    },

    setWidth : function(width) {
	var lightboxElement = lightbox.getBox();
	if (width > document.width - 20) {
	    width = document.width - 20;
	}
	var margin = (document.width - width)/2 - 10; // 10 is the padding
	lightboxElement.style.marginLeft = margin + "px";
	lightboxElement.style.marginRight = margin + "px";
	lightboxElement.style.width = width + "px";
    }
};

function afficheAffiche(el) {
    lightbox.init();
    var box = lightbox.getBox();
    var cheminAffiche = el.getAttribute('data-href');
    
    if (!cheminAffiche || cheminAffiche === "") {
        var p = document.createElement('p');
        p.innerHTML = "L'affiche n'est actuellement pas disponible pour ce film.";
        
        box.appendChild(p);
    } else {
        var imageLightbox = document.createElement('img');
        imageLightbox.src = cheminAffiche;
        
        box.appendChild(imageLightbox);
    }
    
    lightbox.addHideEvents();
    lightbox.display();

    lightbox.setHeight(600);
    lightbox.setWidth(450);
} 

function afficheSynopsis(el) {
    lightbox.init();
    var box = lightbox.getBox();
    var synopsis = el.getAttribute('data-syn');
    var block = document.createElement('blockquote');
    
    block.className = 'text-left white-spaces';
    
    if (!synopsis || synopsis === "") {
        synopsis = "Le synopsis n'est actuellement pas disponible pour ce film.";
    }
    block.innerHTML = synopsis;
    
    box.appendChild(block);

    lightbox.addHideEvents();
    lightbox.display();

    lightbox.setHeight(synopsis.clientHeight);
    lightbox.setWidth(document.width * 0.7);
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
    } else {
        width = width || "100%";
        height = height || (document.body.clientWidth * 9/16);  // Please do not hardcode 1 (100%)
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

    lightbox.setHeight(window.innerHeight);
    lightbox.setWidth(document.width);
}

