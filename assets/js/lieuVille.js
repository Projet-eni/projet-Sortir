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
    xhr.open("GET", "/liste-lieux/" + value, )
}