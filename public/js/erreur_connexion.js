const e = new URLSearchParams(window.location.search).get('error');
const er1 = "Vous n'étiez pas connectés";
const er2 =  "Merci de verifier votre nom d'utilisateur et votre mots de passe";
const er3 =  "Vous n'étiez pas un administrateur";
const er4 =  "Un nouveau administrateur est crié avec succès";

const s = new URLSearchParams(window.location.search).get('logout');
const disc = "Vous étiez déconnectés avec succès"

if (e == 1) {
    document.getElementById('err').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + er1 + "</b></div>";
}else if (e == 2){
    document.getElementById('err').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + er2 + "</b></div>";
}else if (e == 3) {
    document.getElementById('err').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + er3 + "</b></div>";
}else if (s == 'True') {
    document.getElementById('err').innerHTML = "<div style='text-align:center' class='alert alert-primary'><b>" + disc + "</b></div>";
}else {

}