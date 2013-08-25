/*
 * Actions JavaScript générales
 */

function modifier_droits(numero) {
    var noeud_droits = document.getElementById("droits" + numero);
    var droits = noeud_droits.textContent.toString().replace(/ /g,'');
    var login = document.getElementById("login" + numero).innerHTML.toString().replace(/ /g,'');
    var form = document.createElement("form");
    var input_hidden = document.createElement("input");
    var select = document.createElement("select");
    var option1 = document.createElement("option");
    var option2 = document.createElement("option");

    form.id = "form_droits" + numero;
    form.name = "modifier_droits";
    form.setAttribute("method", "GET");
    form.setAttribute("action", "membres.php/modifier_droits");

    input_hidden.name = "login";
    input_hidden.setAttribute("type", "hidden");
    input_hidden.setAttribute("value", login);

    select.name = "droits";
    select.onchange = function() {
        changement_droits(numero);
    };
    option1.setAttribute("value", "1");
    if (droits === "Membre") {
        option1.setAttribute("selected", "selected");
    }
    option1.innerHTML = "Membre";
    option2.setAttribute("value", "2");
    if (droits === "Admin") {
        option2.setAttribute("selected", "selected");
    }
    option2.innerHTML = "Admin";

    select.appendChild(option1);
    select.appendChild(option2);
    form.appendChild(input_hidden);
    form.appendChild(select);
    noeud_droits.appendChild(form);
    noeud_droits.setAttribute("onclick", "annuler_modif_droits(" + numero + ");");
}

function annuler_modif_droits(numero) {
    var noeud_droits = document.getElementById("droits" + numero);
    var droits = noeud_droits.firstChild.textContent;
    noeud_droits.innerHTML = "";
    noeud_droits.textContent = " " + droits + " ";
    noeud_droits.setAttribute("onclick", "modifier_droits(" + numero + ");");
}

function changement_droits(numero) {
    var form = document.getElementById("form_droits" + numero);
    var input_submit = document.createElement("input");
    input_submit.setAttribute("type", "submit");
    form.appendChild(input_submit);
    input_submit.click();
}

function confirme_suppression(numero) {
    var noeud_confirme = document.getElementById("confirme_suppr" + numero);
    var noeud_oui = document.getElementById("supprimer" + numero);
    var noeud_non = document.getElementById("annuler_suppr" + numero);

    noeud_confirme.setAttribute("type", "hidden");
    noeud_oui.setAttribute("type", "submit");
    noeud_non.setAttribute("type", "button");
    noeud_non.onclick = function() {annule_suppression(numero);};
}

function annule_suppression(numero) {
    var noeud_confirme = document.getElementById("confirme_suppr" + numero);
    var noeud_oui = document.getElementById("supprimer" + numero);
    var noeud_non = document.getElementById("annuler_suppr" + numero);

    noeud_confirme.setAttribute("type", "button");
    noeud_oui.setAttribute("type", "hidden");
    noeud_non.setAttribute("type", "hidden");
}


/*
 * Permet de changer certains effets selon les classes
 */

var cacher_input_voter = true;

window.onload = function() {
    zoom_affiches();
    clicdroit();
};

function zoom_affiches() {
    var click = [];
    var i;

    var affiches = document.getElementsByName('affiche');
    var length = affiches.length;

    for (i=0; i<affiches.length; i++) {
        affiches[i].id = "affiche" + i;
        click["affiche" + i] = false;
    }

    for (i=0; i<length; i++) {

        affiches[i].onmouseover = function() {
            zoom(this);
        };

        affiches[i].onmouseout = function() {
            if (!click[this.id]) {
                dezoom(this);
            }
        };

        affiches[i].onclick = function() {
            if (click[this.id]) {
                click[this.id] = false;
                dezoom(this);
            }
            else {
                click[this.id] = true;
            }
        };
    }
}

function clicdroit() {
    var img = document.images;
    var compteur = 0;
    var i;
    var length = img.length;

    for (i=0; i<length; i++) {
        img[i].oncontextmenu = function() {
            compteur++;
            if (compteur > 3) {
                alert("Ce n'est pas la peine d'essayer, tu n'y arriveras pas !");
            }
            return false;
        };
    }
}

function zoom(img){
    img.className = "grande_affiche";
}

function dezoom(img){
    img.className = "affiche";
}

function vote(element) {
    //document.getElementById("soumettre_vote").setAttribute("type", "submit");
    element.getElementsByTagName('input')[0].click();
}

function modifier_affiche() {
    var boutons = document.getElementById("buttons");
    var balises_boutons = boutons.getElementsByTagName("button");
    var input_file = document.createElement("input");
    var input_etat_affiche = boutons.getElementsByTagName("input")[0];

    input_file.setAttribute("type", "file");
    input_file.setAttribute("name", "affiche");

    input_etat_affiche.value = "1";

    balises_boutons[0].style.display = "none";
    balises_boutons[1].style.display = "none";
    boutons.appendChild(input_file);
}
// On remet les boutons après?? -> changer display
function supprimer_affiche() {
    var boutons = document.getElementById("buttons");
    var balises_boutons = boutons.getElementsByTagName("button");
    var texte = document.createElement("p");
    var lien = document.createElement("a");
    var bouton_confirme = document.createElement("button");
    var bouton_infirme = document.createElement("button");

    texte.textContent = "Etes-vous sûr de vouloir supprimer l'affiche ?";
    balises_boutons[0].style.display = "none";
    balises_boutons[1].style.display = "none";
    bouton_confirme.setAttribute("onclick", "suppr_affiche(); return false;");
    bouton_confirme.innerHTML = "Oui";
    lien.setAttribute("href", "#boutons");
    bouton_infirme.setAttribute("onclick", "annule_affiche(); return false;");
    bouton_infirme.innerHTML = "Non";

    lien.appendChild(bouton_infirme);
    boutons.appendChild(texte);
    boutons.appendChild(bouton_confirme);
    boutons.appendChild(bouton_infirme);
}

function suppr_affiche() {
    var boutons = document.getElementById("buttons");
    var input_etat_affiche = boutons.getElementsByTagName("input")[0];
    var balises_boutons = boutons.getElementsByTagName("button");
    var p = boutons.getElementsByTagName("p")[0];

    input_etat_affiche.value = "2";
    balises_boutons[balises_boutons.length-2].style.display = "none";
    balises_boutons[balises_boutons.length-1].style.display = "none";
    p.innerHTML = "Affiche supprimée !";
}

function annule_affiche() {
    var boutons = document.getElementById("buttons");
    var balises_boutons = boutons.getElementsByTagName("button");
    var modif = balises_boutons[0];
    var suppr = balises_boutons[1];

    modif.style.display = "inline";
    suppr.style.display = "inline";

    boutons.innerHTML = "";
    boutons.appendChild(modif);
    boutons.appendChild(suppr);
}