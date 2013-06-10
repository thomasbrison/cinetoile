/* 
 * Actions Javascripts pour l'index
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
    var noeud_non = document.getElementById("annuler_suppr"+numero);
    
    noeud_confirme.setAttribute("type", "hidden");
    noeud_oui.setAttribute("type", "submit");
    noeud_non.setAttribute("type", "button");
    noeud_non.setAttribute("onclick", "annule_suppression(" + numero + ");");
}

function annule_suppression(numero) {
    var noeud_confirme = document.getElementById("confirme_suppr" + numero);
    var noeud_oui = document.getElementById("supprimer" + numero);
    var noeud_non = document.getElementById("annuler_suppr" + numero);
    
    noeud_confirme.setAttribute("type", "button");
    noeud_oui.setAttribute("type", "hidden");
    noeud_non.setAttribute("type", "hidden");
}