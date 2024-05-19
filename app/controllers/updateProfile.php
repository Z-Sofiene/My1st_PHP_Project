<?php

use app\dao\GestionImp;

require_once '../dao/GestionImp.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['id'];
    $nom = !empty($_POST['nom']) ? $_POST['nom'] : null;
    $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $password2 = !empty($_POST['password2']) ? $_POST['password2'] : null;

    $conn = new GestionImp();
    $updateSuccess = false;

    if ($password != $password2) {
        header("Location: ../../public/updateProfile.php?update_result=" . urlencode("password_mismatch"));
        exit();
    } else {
        $updateSuccess = $conn->updatePersonnelById($id, $nom, $prenom, $password);
    }

    if ($updateSuccess) {
        header("Location: ../../public/index.php?update_result=" . urlencode("success"));
    } else {
        header("Location: ../../public/updateProfile.php?update_result=" . urlencode("failure"));
    }
    exit();
}
?>
