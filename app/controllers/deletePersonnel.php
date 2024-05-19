<?php
session_start();

use app\dao\GestionImp;

require_once "../dao/GestionImp.php";

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conn = new GestionImp();
        $conn->deletePersonnel($id);
    } else {
        header("Location: login.php");
        exit();
    }
}
header("Location: ../../public/espacepersonnel.php?page=liste_personnels");
exit();