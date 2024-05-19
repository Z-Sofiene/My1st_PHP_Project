const c = new URLSearchParams(window.location.search).get('ErrorConge');
const er1 = "les dates sont invalids";
const er2 = "Solde congé insufaisant!!!!";
if (c == 1) {
    document.getElementById('err2').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + er1 + "</b></div>";
} else if (c == 2){
    document.getElementById('err2').innerHTML = "<div style='text-align:center' class='alert alert-danger'><b>" + er2 + "</b></div>";
} else {
}