<?php

namespace app\dao;

interface IGestion
{

    // admin
    public function addAdmin($nom,$prenom,$login,$mdp);
    public function getAdminById($id);

    public function getAllAdmins(): array;
    // Personnel
    public function addPersonnel($nom,$prenom,$login,$password);
    public function updatePersonnelById($id);
    public function deletePersonnel($id);
    public function getPersonnelById($id);
    public function getAllPersonnels(): array;
    public function updateSoldeCongeById($idPersonnel, $solde_conge);

    // Conge
    public function addConge($personnel_id, $debut_conge,$fin_conge);
    public function validConge($idConge,$valid);
    public function getAllConges(): array;
    public function getCongeById($idConge);
    public function getAllCongesByPersonnel($id);

    //verif
    public function verifPersonnel($login, $password);
    public function verifAdmin($login, $password);
    public function verifLogin($login);
    public function verifLoginAdmin($login);
    public function verifDateConge($personnel_id, $date);

}