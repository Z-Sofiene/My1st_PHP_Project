<?php
session_start();
if ($_SESSION['role'] != 'user'){
    header('location: ../app/controllers/login.php');
}

use app\dao\GestionImp;

require_once "../app/dao/GestionImp.php";
$conn = new GestionImp();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demander un congé</title>
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top:80px;">
        <div class="row justify-content-center">
            <div class="col-6 bg-light text-black">
                <div class="mt-6">
                    <h1 style="text-align:center">Demander un congé</h1>
                    <br>
                    <form action="../app/controllers/verifConge.php" method="post">
                        <?php
                        echo "<div class='form-group'><h2><b>Nom & Prenom : " . $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</b></h2><br><h3> Solde Congé : " . $_SESSION['conge'] . " </h3></div>";
                        ?>
                        <br><br>
                        <div class="form-group text-danger">
                            <label for="date_debut">Date de début de congé :</label>
                            <input type="date" id="date_debut" name="date_debut" class="form-control" required>
                        </div>
                        <div class="form-group text-danger">
                            <label for="date_fin">Date de fin de congé :</label>
                            <input type="date" id="date_fin" name="date_fin" class="form-control" required>
                        </div>
                        <br><br>
                        <div style="text-align:center" id="btn">
                            <button type="submit" class="btn btn-success">Demander un congé</button>
                        </div>
                        <br>
                        <div id="err2"></div>
                        <script src="js/erreur_conge.js"></script>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
