<?php
session_start();

use app\dao\GestionImp;

require_once "../app/dao/GestionImp.php";
require_once "../app/model/Personnel.php";
require_once "../app/model/Conge.php";
$conn = new GestionImp();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Personnel/Admin</title>
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }
        th {
            background-color: cadetblue;
        }
    </style>
</head>
<body>
<div class="container-fluid">

    <div class="row" style="margin-top:10px;">
        <div class="col-12">
            <?php
            if (isset($_SESSION['role'])) {
                $id = $_SESSION['id'];
                $nom = $_SESSION['nom'];
                $prenom = $_SESSION['prenom'];
                $role = $_SESSION['role'];

                if ($role == 'user') {
                    $soldeconge = $conn->getPersonnelById($id)->getSoldeConge();
                    echo "<div class='card bg-info text-white'><div class='card-header'><h1>Espace Personnel<font size='5pt'> </font></h1><div></div><h1> Bienvenue " . $prenom . "</h1></div></div>";
                } elseif ($role == 'admin') {
                    echo "<div class='card bg-success text-black'><div class='card-header'><h1>Espace Admin<font size='5pt'> </font></h1><div></div><h1> Bienvenue " . $prenom . "</h1></div></div>";
                }
            } else {
                header("Location: ../app/controllers/login.php");
                exit();
            }
            ?>
            <div class="text-right" style="text-align: right">
                <a href="../app/controllers/logout.php" class="btn btn-danger m-lg-2">
                    <h3>se déconnecter</h3>
                </a>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top:10px;">
        <?php
        if ($role == 'user') {
            $activePage = $_GET['page'] ?? 'profile';
            ?>
            <div class="col-3">
                <div class="list-group">
                    <a href="espacepersonnel.php?page=profile" class="list-group-item list-group-item-action <?php echo $activePage == 'profile' ? 'active' : ''; ?>">
                        <span class="fa fa-th-large"></span>
                        <b> Profile </b>
                    </a>
                    <a href="espacepersonnel.php?page=conges" class="list-group-item list-group-item-action <?php echo $activePage == 'conges' ? 'active' : ''; ?>">
                        <span class="fa fa-th-large"></span>
                        <b> Liste des Congés</b>
                    </a>
                </div>
            </div>
            <div class="col-9">
                <div class="card text-black">
                    <?php
                    if ($activePage == 'profile') {
                        ?>
                        <div class="card-header bg-info"><h5>Profile</h5></div>
                        <div class="card-body">
                            <button onclick="window.location.href='modifprofile.php'" class="btn btn-primary mb-3">Modifier votre profile</button>
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Solde congé</th>
                                </tr>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $nom; ?></td>
                                    <td><?php echo $prenom; ?></td>
                                    <td><?php echo $soldeconge; ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php
                    } elseif ($activePage == 'conges') {
                        ?>
                        <div class="card-header bg-info"><h5>Les demandes des congés</h5></div>
                        <div class="card-body">
                            <button onclick="window.location.href='demandeconge.php'" class="btn btn-primary mb-3">Demander un nouveau congé</button>
                        </div>
                        <div class="container" style="margin-top: 80px;">
                            <h1>Liste des congés</h1>
                            <table class="table">
                                <thead>
                                <?php $conges = $conn->getAllCongesByPersonnel($id); ?>
                                    <tr>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                        <th>Validité du congé</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($conges as $conge) : ?>
                                    <tr>
                                        <td><?php echo $conge['debut_conge']; ?></td>
                                        <td><?php echo $conge['fin_conge']; ?></td>
                                        <td>
                                            <?php
                                            if ($conge['validConge'] === null) {
                                                echo 'En traitement';
                                            } else if ($conge['validConge']) {
                                                echo 'Validé';
                                            } else {
                                                echo 'Non Validé';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        } elseif ($role == 'admin') {
            $activePage = $_GET['page'] ?? 'liste_personnels';
            ?>
            <div class="col-3">
                <div class="list-group">
                    <a href="espacepersonnel.php?page=liste_personnels" class="list-group-item list-group-item-action <?php echo $activePage == 'liste_personnels' ? 'active' : ''; ?>">
                        <span class="fa fa-th-large"></span>
                        <b> Liste des Personnels </b>
                    </a>
                    <a href="espacepersonnel.php?page=gestion_conges" class="list-group-item list-group-item-action <?php echo $activePage == 'gestion_conges' ? 'active' : ''; ?>">
                        <span class="fa fa-th-large"></span>
                        <b> Gestion des Congés </b>
                    </a>
                </div>
            </div>
            <div class="col-9">
                <div class="card text-black">

                    <?php
                    if ($activePage == 'liste_personnels') {
                        ?>
                        <div class="card-header bg-success"><h5>Liste des Personnels</h5></div>
                        <div class="card-body">
                            <a onclick="window.location.href='ajoutadmin.php'" class="btn btn-danger mb-3">Ajouter un Admin</a>
                            <table>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Solde Congé</th>
                                    <th>Actions</th>
                                </tr>
                                <?php $personnels = $conn->getAllPersonnels(); ?>
                                <?php foreach ($personnels as $personnel) : ?>
                                <tr>
                                    <td><?php echo $personnel['nom']; ?></td>
                                    <td><?php echo $personnel['prenom']; ?></td>
                                    <td><?php echo $personnel['solde_conge']; ?></td>
                                    <td>
                                        <button onclick="window.location.href='../app/controllers/deletePersonnel.php?id=<?php echo urlencode($personnel['id']); ?>'" class="btn btn-danger">Supprimer</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <?php
                    } elseif ($activePage == 'gestion_conges') {
                        ?>
                        <div class="card-header bg-success"><h5>Gestion des Congés</h5></div>
                        <div class="card-body">
                            <h1>Liste des Congés</h1>
                            <table class="table">
                                <thead>
                                <?php $conges = $conn->getAllConges(); ?>
                                    <tr>
                                        <th>Nom et Prenom</th>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                        <th>Validité du congé</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($conges as $conge) :
                                        $nom = $conn->getPersonnelById($conge['personnel_id'])->getNom();
                                        $prenom = $conn->getPersonnelById($conge['personnel_id'])->getPrenom();
                                        $debutConge = new DateTime($conge['debut_conge']);
                                        $finConge = new DateTime($conge['fin_conge']);
                                    ?>
                                    <tr>
                                        <td><?php echo $nom . ' ' . $prenom ?></td>
                                        <td><?php echo $conge['debut_conge']; ?></td>
                                        <td><?php echo $conge['fin_conge']; ?></td>
                                        <td>
                                            <?php
                                            if ($conge['validConge'] === null) {
                                                    echo 'En traitement';
                                                } else if ($conge['validConge']) {
                                                    echo 'OK';
                                                } else {
                                                    echo 'Non';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                        <?php
                                        if ($conn->getPersonnelById($conge['personnel_id'])->getSoldeConge() >= ($debutConge->diff($finConge)->days) && $conge['validConge'] === null ) { ?>
                                            <button onclick="window.location.href='../app/controllers/validConge.php?id=<?php echo urlencode($conge['id']); ?>&valid=1'" class="btn btn-success">Approuver</button>
                                            <?php }
                                        if ($conge['validConge'] === null) { ?>
                                            <button onclick="window.location.href='../app/controllers/validConge.php?id=<?php echo urlencode($conge['id']); ?>&valid=0'" class="btn btn-danger">Rejeter</button>
                                        <?php } ?>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>
