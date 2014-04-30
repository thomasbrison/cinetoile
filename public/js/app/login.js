var loginExists = true;

function checkLogin(login) {

    var appendingEl = document.getElementById('loginExists');

    if (!login) {
        appendingEl.innerText = "";
        return false;
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState === 4 && (request.status === 200 || request.status === 0)) {
            loginExists = (request.responseText === "Le login est déjà utilisé !");
            appendingEl.innerText = request.responseText;
            appendingEl.className = loginExists ? "exists" : "available";
        }
    };

    request.open("GET", "membres/loginExists?login=" + login, true);
    request.send(null);

    return loginExists;

}