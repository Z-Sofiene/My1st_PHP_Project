<?php
session_start();
$fileAdmin = '.adminExist';
if(!file_exists($fileAdmin)){
    $fd = fopen($fileAdmin, 'w');
    if ($fd) {
        fclose($fd);
        $_SESSION['role'] = 'admin';
        header('Location: ajoutAdmin.php');
        exit();
        }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=2.0">
    <title>Connexion</title>
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top:80px;">
        <div class="row justify-content-center">
            <div class="col-6 bg-warning text-black">
                <div class="mt-6">
                    <h1 style="text-align:center" >Connexion</h1>
                    <br>
                    <form action="../app/controllers/login.php" method="post">
                        <div class="form-group">
                            <label for="username">Utilisateur:</label>
                        </div>
                        <div style="text-align: center">
                            <label >
                                <input type="text" id="username" name="username" required>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="password">mots de passe:</label>
                        </div>
                        <div style="text-align: center">
                            <label>
                                <input type="password" id="password" name="password" required>
                            </label>
                        </div>
                        <br><br>
                        <div style="text-align:center">
                            <button type="submit" class="btn btn-success mb-4">Se Connecter</button>
                        </div>
                    </form>
                    <div style="text-align: right">
                        <button onclick="window.location.href='inscription.php'" class="btn btn-warning mb-1"><b>Inscrivez-vous</b></button>
                        </div>
                </div>
                <div id="err"></div>
            </div>
        </div>
    </div>

    <script src="js/erreur_connexion.js"></script>
</body>
</html>
