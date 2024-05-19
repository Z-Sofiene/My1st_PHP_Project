<?php

use app\dao\GestionImp;

require_once '../dao/GestionImp.php';
if ($_SESSION['role'] != "admin") {
    header("Location: ../../public/index.php?error=3");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $conn = new GestionImp();
        if (!$conn->verifLoginAdmin($username)) {
            $s = 1;
        }else if ($password != $password2) {
            $s = 2;
        }else if ($conn->addAdmin($nom, $prenom, $username, $password)) {
            header("Location: ../../public/index.php");
            exit();
        }else{
            $s = 3;
        }
        header("Location: ../../public/ajoutadmin.php?signup_result=" . urlencode($s));
        exit();
    }
}

