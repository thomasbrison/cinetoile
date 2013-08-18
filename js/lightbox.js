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
    }
};

function afficheAffiche(el) {
    lightbox.init();
    var box = lightbox.getBox();
    var cheminAffiche = el.getAttribute('data-href');
    
    if (!cheminAffiche || cheminAffiche === "") {
        var div = document.createElement('div');
        var p = document.createElement('p');
        div.className = 'conteneur-lightbox';
        p.innerHTML = "L'affiche n'est actuellement pas disponible pour ce film.";
        
        box.innerHTML = "";
        div.appendChild(p);
        box.appendChild(div);
    } else {
        var imageLightbox = document.createElement('img');
        imageLightbox.src = cheminAffiche;
        
        box.innerHTML = "";
        box.appendChild(imageLightbox);
    }
    
    lightbox.addHideEvents();
    lightbox.display();
} 

function afficheSynopsis(el) {
    lightbox.init();
    var box = lightbox.getBox();
    var synopsis = el.getAttribute('data-syn');
    var container = document.createElement('div');
    var block = document.createElement('blockquote');
    
    container.className = 'conteneur-lightbox';
    block.className = 'text-left white-spaces';
    
    if (!synopsis || synopsis === "") {
        synopsis = "Le synopsis n'est actuellement pas disponible pour ce film.";
    }
    block.innerHTML = synopsis;
    
    box.innerHTML = "";
    container.appendChild(block);
    box.appendChild(container);

    lightbox.addHideEvents();
    lightbox.display();

    var blockHeight = block.clientHeight;
    var boxHeight = box.clientHeight;
    container.style.top = (boxHeight - blockHeight)/3 + "px";
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
    
    box.innerHTML = "";
    box.appendChild(container);
    lightbox.addHideEvents();
    lightbox.display();

    if (iframe) {
        var iframeHeight = iframe.clientHeight;
        var boxHeight = box.clientHeight;
        container.style.top = (boxHeight - container.style.paddingTop - container.style.paddingBottom - iframeHeight)/3  + "px";
//        container.style.left = (document.body.clientWidth - iframe.clientWidth)/3 + "px";
    }
}

