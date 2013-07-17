var lightbox = {
    isHidden : true,
            
    display : function() {
        var lightbox = document.getElementById("lightbox");
        lightbox.className = 'visible';
        this.isHidden = false;
    },
            
    hide : function(event) {
        var box = lightbox.getBox();

        if (event && event.target !== box) return;

        box.innerHTML = "";
        box.className = '';
        this.isHidden = true;
    },
    
    getBox : function() {
        if (document) {
            return document.getElementById("lightbox");
        } else {
            return null;
        }
    },
            
    addHideEvents : function() {
        lightbox.getBox().addEventListener('click', lightbox.hide, false);
        document.addEventListener('keyup', function(event) {
            // Touche echap
            if (event.keyCode === 27) {
                lightbox.hide();
            }
        }, false);
    }        
};

function afficheAffiche(el) {
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
