<?php
    session_start();
    if ($_SESSION['role'] != "admin") {
        header("Location: index.php?error=3");
        exit();
    }
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Admin</title>
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <p><a href="espacepersonnel.php"> Home </a></p>
    <div class="container" style="margin-top:80px;">
        <div class="row justify-content-center">
            <div class="col-6 bg-danger text-black">
                <div class="mt-6">
                    <h1 style="text-align:center" >Ajouter un Administrateur</h1>
                    <br>
                    <form action="../app/controllers/addAdmin.php" method="post">
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom :</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Utilisateur:</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Mot de passe:</label>
                            <input type="password" id="password2" name="password2" class="form-control" required>
                        </div>
                        <br><br>
                        <div style="text-align:center" id="btn">
                            <button type="submit" class="btn btn-success">S'inscrire</button>
                        </div>
                    </form>
                </div>
                <div id="err1"></div>
                <div id="msg"></div>
                <script src="js/erreur_signup.js"></script>
            </div>
        </div>
    </div>
</body>
</html>