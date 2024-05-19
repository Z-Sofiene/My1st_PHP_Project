<?php

use app\dao\GestionImp;

require_once '../dao/GestionImp.php';
require_once '../model/Admin.php';
require_once '../model/Personnel.php';
$username = $_POST['username'];
$password = $_POST['password'];
$conn = new GestionImp();

session_start();

if ($conn->verifAdmin($username, $password) != null){
    $id = $conn->verifAdmin($username, $password);
    $_SESSION['id'] = $id;
    $_SESSION['role'] = "admin";
    $_SESSION['nom'] = $conn->getAdminById($id)->getNom();
    $_SESSION['prenom'] = $conn->getAdminById($id)->getPrenom();
    header("Location: ../../public/espacepersonnel.php?page=liste_personnels");
}else if ($conn->verifPersonnel($username, $password) != null) {
    $id = $conn->verifPersonnel($username, $password);
    $_SESSION['id'] = $id;
    $_SESSION['role'] = "user";
    $_SESSION['nom'] = $conn->getPersonnelById($id)->getNom();
    $_SESSION['prenom'] = $conn->getPersonnelById($id)->getPrenom();
    $_SESSION['conge'] = $conn->getPersonnelById($id)->getSoldeConge();
    header('Location: ../../public/espacepersonnel.php?page=profile');
} else if ($username == "" && $password == ""){
    header("Location: ../../public/index.php?error=1");
} else {
    header("Location: ../../public/index.php?error=2");
}
exit();

