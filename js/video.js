function affichage_video(id) {
    var video = document.getElementById("vid" + id);
    var msg = document.getElementById("disp" + id);
    
    if (video.style.display === "block") {
	msg.innerHTML = "Voir la bande-annonce";
	video.style.display = "none";
    }
    else {
	msg.innerHTML = "Masquer la bande-annonce";
        video.style.display = "block";
    }
}
