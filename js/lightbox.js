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

function afficheBandeAnnonce(el) {
    var box = lightbox.getBox();
    var bandeAnnonce = el.getAttribute('data-ba');
    var div = document.createElement('div');
    
    if (!bandeAnnonce || bandeAnnonce === "") {
        div.className = 'conteneur-lightbox';
        var p = document.createElement('p');
        p.innerHTML = "La bande-annonce n'est actuellement pas disponible pour ce film.";
        
        div.appendChild(p);
    } else {
        div.className =  'bande-annonce-lightbox';
        bandeAnnonce = bandeAnnonce.replace(/&amp;/g,"&");
        bandeAnnonce = bandeAnnonce.replace(/&lt;/g,"<");
        bandeAnnonce = bandeAnnonce.replace(/&gt;/g,">");
        bandeAnnonce = bandeAnnonce.replace(/&quot;/g,"\"");
        div.innerHTML = bandeAnnonce;
    }
    
    box.innerHTML = "";
    box.appendChild(div);
    lightbox.addHideEvents();
    lightbox.display();
}