<?php

use app\dao\GestionImp;

require_once '../dao/GestionImp.php';
require_once '../model/Conge.php';
require_once '../model/Personnel.php';
session_start();
$conn = new GestionImp();

$id = $_SESSION['id'];
$date1 = $_POST["date_debut"];
$date2 = $_POST["date_fin"];

if ($id != null && $date1 != null && $date2 != null) {
    $solde_conge = $conn->getPersonnelById($id)->getSoldeConge();
    $date0 = $conn->verifDateConge($id, $date1);

    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $date0 = new DateTime($date0);

    if ($date1 > $date2) {
        header("Location: ../../public/demandeconge.php?ErrorConge=1");
        exit();
    } else if ($solde_conge <= $date1->diff($date2)->days) {
        header("Location: ../../public/demandeconge.php?ErrorConge=2");
        exit();
    }

    if ($date1 < $date0) {
        $date1 = $date0->modify('+1 day');
    }
    if ($date2 < $date0) {
        $date2 = $date0->modify('+2 day');
    }

    $conn->addConge($id, $date1->format('Y-m-d'), $date2->format('Y-m-d'));

    header("Location: ../../public/espacepersonnel.php?page=conges");
    exit();
} else {
    header("Location: logout.php");
    exit();
}
?>
