<?php
use app\dao\GestionImp;
require_once "../dao/GestionImp.php";
require_once "../model/Conge.php";
require_once "../model/Personnel.php";
session_start();
if (isset($_GET['id']) && isset($_GET['valid'])) {
    $idConge = $_GET['id'];
    $valid = $_GET['valid'] == '1';
    $conn = new GestionImp();
    $conn->validConge($idConge, $valid);
    header("Location: ../../public/espacepersonnel.php?page=gestion_conges");
} else {
    header("Location: error.php");
}
exit();
