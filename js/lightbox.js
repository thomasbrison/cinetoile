var lightbox = {
    isHidden : true,
            
    display : function() {
        var lightbox = document.getElementById("lightbox");
        lightbox.setAttribute('class', 'visible');
        this.isHidden = false;
    },
            
    hide : function() {
        var lightbox = document.getElementById("lightbox");
        lightbox.setAttribute('class', '');
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
        //document.addEventListener('click', lightbox.hide, false);
        document.addEventListener('keyup', function(e) {
            if (e.keyCode === 27) {
                lightbox.hide();
            }
        }, false);
    }        
};

function afficheAffiche(numeroLigne) {
    var box = lightbox.getBox();
    var elAffiche = document.getElementById("affiche" + numeroLigne);
    var cheminAffiche = elAffiche.getElementsByTagName('a')[0].getAttribute('data-href');
    
    if (!cheminAffiche || cheminAffiche === "") {
        var div = document.createElement('div');
        var p = document.createElement('p');
        div.setAttribute('class', 'conteneur-lightbox');
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

function afficheSynopsis(numeroLigne) {
    var box = lightbox.getBox();
    var elSynopsis = document.getElementById("synopsis" + numeroLigne);
    var synopsis = elSynopsis.getElementsByTagName('p')[0].innerHTML;
    var div = document.createElement('div');
    var p = document.createElement('p');
    
    div.setAttribute('class', 'conteneur-lightbox');
    
    if (!synopsis || synopsis === "") {
        synopsis = "Le synopsis n'est actuellement pas disponible pour ce film.";
    }
    p.innerHTML = synopsis;
    
    box.innerHTML = "";
    div.appendChild(p);
    box.appendChild(div);
    lightbox.addHideEvents();
    lightbox.display();
}

function afficheBandeAnnonce(numeroLigne) {
    var box = lightbox.getBox();
    var elBandeAnnonce = document.getElementById("bande_annonce" + numeroLigne);
    var bande_annonce = elBandeAnnonce.getElementsByTagName('div')[0].innerHTML;
    var div = document.createElement('div');
    
    if (!bande_annonce || bande_annonce === "") {
        div.setAttribute('class', 'conteneur-lightbox');
        var p = document.createElement('p');
        p.innerHTML = "La bande-annonce n'est actuellement pas disponible pour ce film.";
        
        div.appendChild(p);
    } else {
        div.setAttribute('class', 'bande-annonce-lightbox');
        bande_annonce = bande_annonce.replace(/&amp;/g,"&");
        bande_annonce = bande_annonce.replace(/&lt;/g,"<");
        bande_annonce = bande_annonce.replace(/&gt;/g,">");
        bande_annonce = bande_annonce.replace(/&quot;/g,"\"");
        div.innerHTML = bande_annonce;
    }
    
    box.innerHTML = "";
    box.appendChild(div);
    lightbox.addHideEvents();
    lightbox.display();
}