/*function zoom_affiches() {
    var affiches=document.getElementsByName("affiche");
    var click=false;
    var i;
    
    for (i=0;i<affiches.length;i++) {    

        affiches[i].onmouseover = function() {
            zoom(affiche);
        };
        affiches[i].onmouseout = function() {
            if (!click) {
                dezoom(affiche);
            }
        };
        affiches[i].onclick = function() {
            if (click) {
                dezoom(affiche);
                click=false;
            }
            else {
                click=true;
            }
        };
    
    }
}

function clicdroit() {
    var img=document.images;
    var compteur=0;
    var i;
    
    for (i=0;i<img.length;i++) {
        img[i].oncontextmenu = function() {
            compteur++;
            if (compteur>3) {
                alert("Ce n'est pas la peine d'essayer, tu n'y arriveras pas !");
            }
            return false;
        };
    }
}



function zoom(img){
    img.style.height="12cm";
    img.style.width="9cm";
}

function dezoom(img){
    img.style.height="4cm";
    img.style.width="3cm";
}*/