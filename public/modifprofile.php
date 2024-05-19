<?php

use app\dao\GestionImp;
require_once '../app/dao/GestionImp.php';
require_once '../app/model/Personnel.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header("Location: ../app/controllers/login.php");
    exit();
}
$conn = new GestionImp();

$user = $conn->getPersonnelById($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour le profil</title>
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top:80px;">
        <div class="row justify-content-center">
            <div class="col-6 bg-warning text-black">
                <div class="mt-6">
                    <h1 style="text-align:center">Mettre à jour le profil</h1>
                    <br>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="oldPassword">Votre mots de passe :</label>
                            <input type="password" id="oldPassword" name="oldPassword" class="form-control" required>
                        </div>
                        <div style="text-align: center">
                            <button type="submit" class="btn btn-success">Confirmez votre mots de passe</button>
                        </div>
                    </form>
                    <form action="../app/controllers/updateProfile.php" method="post">
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" class="form-control" value="<?php echo $user->getNom(); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom :</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo $user->getPrenom(); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Nouveau mot de passe:</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password2">Confirmer le mot de passe:</label>
                            <input type="password" id="password2" name="password2" class="form-control">
                        </div>
                        <br><br>
                        <div style="text-align:center" >
                            <?php
                            if (isset($_POST["oldPassword"]) && $conn->verifPersonnel($user->getLogin(), $_POST["oldPassword"])){
                                ?>
                            <button type="submit" class="btn btn-success">Mettre à jour</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
                <div id="err1"></div>
                <div id="msg"></div>
            </div>
        </div>
    </div>
</body>
</html>