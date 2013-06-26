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
        if (xmlhttp.readyState == 4 && (xmlhttp.status == 200 || xmlhttp.status == 0)) {

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

function goToPreviousPage(currentPage, finalPage) {
    finalPage.className = "film page page-left";
    document.getElementById("main").appendChild(finalPage);
    
    setTimeout(function() {
        currentPage.className = "film page page-right";
        finalPage.className = "film page page-center";
    }, 0);
}

function goToNextPage(currentPage, finalPage) {
    finalPage.className = "film page page-right";
    document.getElementById("main").appendChild(finalPage);
    
    setTimeout(function() {
        currentPage.className = "film page page-left";
        finalPage.className = "film page page-center";
    }, 0);
}