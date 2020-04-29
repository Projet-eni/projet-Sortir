window.onload = init;

function init() {
    document.getElementById('sortie_lieu').addEventListener('change', charge);
    charge();
}
function charge(){
    if (document.getElementById('sortie_lieu')!==null){
        let lieu = document.getElementById('sortie_lieu');
        afficher(lieu.value);
    }
    else{
        console.log("erreur");
    }


}
function afficher(value){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200){
            var lieu = JSON.parse(this.responseText);
            document.getElementById("ville").innerText = lieu.ville;
            document.getElementById("rue").innerText = lieu.rue;
            document.getElementById("codePostal").innerText = lieu.codePostal;
            document.getElementById("latitude").innerText = lieu.latitude;
            document.getElementById("longitude").innerText = lieu.longitude;
        }
    };
    xhr.open("GET", "/liste-lieux/" + value, true);
    xhr.send();
}