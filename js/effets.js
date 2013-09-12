/*
 * Actions JavaScript générales
 */

function displayMessage(message) {
    var msgEl = document.createElement('nav');
    msgEl.className = "message";
    msgEl.innerText = message;
    document.body.appendChild(msgEl);
}

function displaySelections(displayedEl) {
    var formElement = displayedEl.parentNode.querySelector('form');
    displayedEl.className = "js-el hidden";
    formElement.className = "";
}

function displayElement(displayedEl, elInnerHTML) {
    var formElement = displayedEl.parentNode.querySelector('form');
    displayedEl.innerHTML = elInnerHTML;
    displayedEl.className = "js-el";
    formElement.className = "hidden";
}

function updateTable(formEl, primaryKeyName, keyName) {
    var displayedEl = formEl.parentNode.querySelector('.js-el');
    var formAction = formEl.getAttribute('action');
    var primaryKeyValue = formEl.elements[primaryKeyName].value;
    var chosenEl = formEl.elements[keyName];
    var chosenValue = parseInt(chosenEl.value);
    var chosenHTML = chosenEl.options[chosenEl.selectedIndex].innerHTML;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && (xmlhttp.status === 200 || xmlhttp.status === 0)) {
            displayElement(displayedEl, chosenHTML);
        }
    };

    xmlhttp.open("GET", formAction + "?" + primaryKeyName + "=" + primaryKeyValue + "&" + keyName + "=" + chosenValue, true);
    xmlhttp.send(null);

    return false;
}

function changerDroits(formEl) {
    return updateTable(formEl, 'login', 'droits');
}

function confirm(el) {
    var parentEl = el.parentNode;
    var yesEl = document.createElement('input');
    var noEl = document.createElement('input');

    yesEl.setAttribute("type", "submit");
    noEl.setAttribute("type", "button");
    yesEl.value = "Oui";
    noEl.value = "Non";

    noEl.onclick = function() {
        cancel(el);
    };

    el.className = "hidden";
    parentEl.appendChild(yesEl);
    parentEl.appendChild(noEl);
}

function cancel(el) {
    var parentEl = el.parentNode;
    var yesEl = parentEl.querySelector('input[value="Oui"]');
    var noEl = parentEl.querySelector('input[value="Non"]');

    parentEl.removeChild(yesEl);
    parentEl.removeChild(noEl);

    el.className = "";
}

function removeTable(formEl, elToRemove, primaryKeyName) {
    var formAction = formEl.getAttribute('action');
    var primaryKeyValue = formEl.elements[primaryKeyName].value;

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState === 4 && (request.status === 200 || request.status === 0)) {
            var response = request.responseText;
            var removed = parseInt(response[0]);
            var message = response.substring(1);
            displayMessage(message);
            if (removed) {
                elToRemove.parentNode.removeChild(elToRemove);
            }
        }
    };

    request.open("GET", formAction + "?" + primaryKeyName + "=" + primaryKeyValue, true);
    request.send(null);

    return false;
}

function removeFilm(formEl) {
    return removeTable(formEl, formEl.parentNode.parentNode.parentNode, 'id');
}

function removeMembre(formEl) {
    return removeTable(formEl, formEl.parentNode.parentNode.parentNode, 'login');
}

function removeDiffusion(formEl) {
    return removeTable(formEl, formEl.parentNode.parentNode.parentNode, 'date');
}

function confirmLink(yesEl) {
    var parentEl = yesEl.parentNode;
    var noEl = document.createElement('a');
    var yesText = yesEl.innerText;

    noEl.className = "button no";
    noEl.innerHTML = "Non";
    yesEl.innerHTML = "Oui";
    yesEl.className += " yes";

    noEl.onclick = function() {
        cancelLink(yesEl, yesText);
    };
    yesEl.onclick = null;

    parentEl.appendChild(noEl);

    return false;
}

function cancelLink(yesEl, innerText) {
    var parentEl = yesEl.parentNode;
    var nbChilds = parentEl.childNodes.length;
    var noEl = parentEl.childNodes[nbChilds - 1];

    yesEl.innerText = innerText;
    yesEl.className = 'button';

    yesEl.onclick = function() {
        return confirmLink(this);
    }

    parentEl.removeChild(noEl);
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