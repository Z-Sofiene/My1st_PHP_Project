<?php

namespace app\dao;
use app\model\Admin;
use app\model\Conge;
use app\model\Personnel;

require_once 'IGestion.php';;

use DateTime;
use mysqli;

class GestionImp implements IGestion
{

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "personnel_conge_db";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

    }
    public function addAdmin($nom, $prenom, $login, $mdp)
    {
        $pass = password_hash($mdp, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO admin (nom, prenom, login, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $login, $pass);
        $stmt->execute();
        $row = $stmt->affected_rows;
        $stmt->close();
        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdminById($id): Admin
    {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $nom, $prenom, $login, $password);
        $stmt->fetch();
        $admin = new Admin($id, $nom, $prenom, $login, $password);
        $stmt->close();
        return $admin;
    }

    public function getAllAdmins(): array
    {
        $query = "SELECT * FROM admin";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
        $stmt->close();
        return $admins;
    }


    //// Personnel
    public function addPersonnel($nom, $prenom, $login, $password)
    {
        $solde_conge = 30;
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO Personnel (nom, prenom, login, password, solde_conge) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nom, $prenom, $login, $pass, $solde_conge);
        $stmt->execute();
        $row = $stmt->affected_rows;
        $stmt->close();
        if ($row > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePersonnelById($id, $nom = null, $prenom = null, $password = null) {
    $fields = [];
    $params = [];
    $types = '';

    if ($nom !== null) {
        $fields[] = "nom = ?";
        $params[] = $nom;
        $types .= 's';
    }

    if ($prenom !== null) {
        $fields[] = "prenom = ?";
        $params[] = $prenom;
        $types .= 's';
    }

    if ($password !== null) {
        $fields[] = "password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
        $types .= 's';
    }

    if (count($fields) == 0) {
        return false;
    }

    $params[] = $id;
    $types .= 'i';

    $stmt = $this->conn->prepare("UPDATE Personnel SET " . implode(', ', $fields) . " WHERE id = ?");
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close();

    return $affected_rows > 0;
}


    public function updateSoldeCongeById($idPersonnel, $solde_conge)
    {   $stmt = $this->conn->prepare("UPDATE Personnel SET solde_conge = ? WHERE id = ?");
        $stmt->bind_param("si", $solde_conge, $idPersonnel);
        $stmt->execute();
        $stmt->close();
    }

    public function deletePersonnel($id)
    {
            $stmt = $this->conn->prepare("DELETE FROM Personnel WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();

    }

    public function getPersonnelById($id): Personnel
    {
            $stmt = $this->conn->prepare("SELECT * FROM personnel WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($id, $nom, $prenom,$login, $password, $solde_conge);
            $stmt->fetch();
            $personnel = new Personnel($id, $nom, $prenom,$login, $password, $solde_conge);
            $stmt->close();
            return $personnel;
    }

    public function getAllPersonnels(): array
    {
        $query = "SELECT * FROM personnel";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $Personnel = [];
        while ($row = $result->fetch_assoc()) {
            $Personnel[] = $row;
        }
        $stmt->close();
        return $Personnel;
    }

    public function addConge($personnel_id, $debut_conge, $fin_conge)
    {
        $validConge = null;
        $stmt = $this->conn->prepare("INSERT INTO conge (personnel_id, debut_conge, fin_conge, validConge ) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $personnel_id, $debut_conge, $fin_conge, $validConge);
        $stmt->execute();
        $row = $stmt->affected_rows;
        $stmt->close();
        if ($row> 0) {
            return true;
        } else {
            return false;
        }
    }
    public function getCongeById($idConge): Conge
    {
        $stmt = $this->conn->prepare("SELECT * FROM conge WHERE id = ?");
        $stmt->bind_param("i", $idConge);
        $stmt->execute();
        $stmt->bind_result($idConge,$personnel_id, $debut_conge, $fin_conge, $validConge);
        $stmt->fetch();
        $conge = new Conge($idConge,$personnel_id, $debut_conge, $fin_conge, $validConge);
        $stmt->close();
        return $conge;
    }
public function validConge($idConge, $valid)
{
    $conge = $this->getCongeById($idConge);
    $validConge = $conge->getValidConge();

    if ($validConge === null) {
        $personnel_id = $conge->getPersonnelId();
        $personnel = $this->getPersonnelById($personnel_id);
        $solde_conge = $personnel->getSoldeConge();

        $date1 = new DateTime($conge->getDebutConge());
        $date2 = new DateTime($conge->getFinConge());
        $days_difference = $date1->diff($date2)->days;

        if ($valid) {
            $solde_conge -= $days_difference;
            $this->updateSoldeCongeById($personnel_id, $solde_conge);
        }

        $stmt = $this->conn->prepare("UPDATE conge SET validConge = ? WHERE id = ?");
        $stmt->bind_param("ii", $valid, $idConge);
        $stmt->execute();
        $stmt->close();
    }




    }

    public function getAllConges(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Conge");
        $stmt->execute();
        $result = $stmt->get_result();
        $conge = [];
        while ($row = $result->fetch_assoc()) {
            $conge[] = $row;
        }
        $stmt->close();
        return $conge;
    }

    public function getAllCongesByPersonnel($personnelId) : array
    {
        $stmt = $this->conn->prepare("SELECT * FROM Conge WHERE personnel_id = ?");
        $stmt->bind_param("i", $personnelId);
        $stmt->execute();
        $result = $stmt->get_result();
        $conge = [];
        while ($row = $result->fetch_assoc()) {
            $conge[] = $row;
        }
        $stmt->close();
        return $conge;
    }

    public function verifPersonnel($login, $password) {
        $stmt = $this->conn->prepare("SELECT id,password FROM Personnel WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                return $row['id'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function verifLogin($login): bool
    {
        $stmt = $this->conn->prepare("SELECT id FROM Personnel WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return false;
        } else {
            return true;
        }
    }

       public function verifLoginAdmin($login): bool
       {
        $stmt = $this->conn->prepare("SELECT id FROM admin WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            return false;
        } else {
            return true;
        }
    }

     public function verifAdmin($login, $password)
     {
        $stmt = $this->conn->prepare("SELECT id,password FROM admin WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                return $row['id'];
            } else {
                return null;
            }
        } else {
            return null;
        }
     }


    public function verifDateConge($personnel_id, $date)
    {
        $stmt = $this->conn->prepare("SELECT MAX(fin_conge) AS max_date FROM conge WHERE personnel_id = ?");
        $stmt->bind_param("i", $personnel_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $max_date = null;
        if ($result && $row = $result->fetch_assoc()) {
            $max_date = $row['max_date']; // Get the maximum date
        }
        $stmt->close();
        return $max_date;
    }
}