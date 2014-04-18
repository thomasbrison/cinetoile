/*
 * Effets Ajax/JavaScript pour visualiser les séances précédentes/suivantes
 */

/**
 * Charge une page en Ajax
 *
 * @param {Integer} currentPageNumber
 * @param {Integer} pageNumber
 * @param {Integer} nbPages
 * @returns {undefined}
 */
function loadPage(currentPageNumber, pageNumber, nbPages) {
    var direction = pageNumber - currentPageNumber;
    if (direction === 0 || currentPageNumber < 0 || pageNumber < 0 || pageNumber > nbPages || currentPageNumber > nbPages) {
        console.error("Fonction loadPage utilisée de manière incorrecte.\n"
                + "Arguments :\n"
                + "currentPageNumber = " + currentPageNumber + "\n"
                + "pageNumber = " + pageNumber + "\n"
                + "nbPages = " + nbPages);
        return;
    }

    var currentPage = document.getElementById("seance" + currentPageNumber);
    var finalPage = document.getElementById("seance" + pageNumber);

    if (!currentPage) {
        console.error("La page courante que vous appelez n'existe pas.");
        return;
    }

    if (finalPage) {
        if (direction < 0) {
            // On revient en arrière
            goToPreviousPage(currentPage, finalPage);
        } else {
            // On avance
            goToNextPage(currentPage, finalPage);
        }
        return;
    }

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && (xmlhttp.status === 200 || xmlhttp.status === 0)) {

            var div = document.createElement('div');
            div.innerHTML = xmlhttp.responseText;
            var finalPage = div.firstElementChild;

            if (direction < 0) {
                // On revient en arrière
                goToPreviousPage(currentPage, finalPage);
            } else {
                // On avance
                goToNextPage(currentPage, finalPage);
            }

        }
    };

    xmlhttp.open("GET", "index.php?page=" + pageNumber + "&isajax=1", true);
    xmlhttp.send(null);
}

/**
 * Fonction générique pour appliquer un effet de slide
 *
 * @param {DOMElement} currentPage
 * @param {DOMElement} finalPage
 * @param {String} originClassName
 * @param {String} directionClassName
 * @returns {undefined}
 */
function slidePage(currentPage, finalPage, originClassName, directionClassName) {
    currentPage.className = "stage-center seance";
    finalPage.className = "seance " + originClassName;
    document.getElementById("seances").appendChild(finalPage);
    
    setTimeout(function() {
        currentPage.className = "seance " + directionClassName;
        finalPage.className = "stage-center seance";
    }, 0);
}

/**
 * Applique un effet de slide pour voir la page précédente
 *
 * @param {DOMElement} currentPage
 * @param {DOMElement} finalPage
 * @returns {undefined}
 */
function goToPreviousPage(currentPage, finalPage) {
    slidePage(currentPage, finalPage, "stage-left", "stage-right");
}

/**
 * Applique un effet de slide pour voir la page suivante
 *
 * @param {DOMElement} currentPage
 * @param {DOMElement} finalPage
 * @returns {undefined}
 */
function goToNextPage(currentPage, finalPage) {
    slidePage(currentPage, finalPage, "stage-right", "stage-left");
}