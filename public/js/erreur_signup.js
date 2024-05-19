const e = new URLSearchParams(window.location.search).get('signup_result');
const err1 = "Le nom d'utilisateur exist déja";
const err2 = "Les mots de passe ne correspondent pas.";
const err3 = "l'utilisateur n'était pas ajouté !!!!";


if (e == 1) {
    document.getElementById('err1').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + err1 + "</b></div>";
}else if (e == 2){
    document.getElementById('err1').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + err2 + "</b></div>";
}else if (e == 3) {
    document.getElementById('err1').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + err3 + "</b></div>";
} else {

}