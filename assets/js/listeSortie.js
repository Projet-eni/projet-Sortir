window.addEventListener("load", init);

function init() {

    let liste = document.getElementById('listColor');

    let lignes = liste.getElementsByTagName('tr')

    for (let i = 0; i < lignes.length; i++){

        let regex = RegExp('^[0-9]*[02468]$');
        if ( regex.test(i)){
            lignes[i].setAttribute('id','pair');
        }
    }
}