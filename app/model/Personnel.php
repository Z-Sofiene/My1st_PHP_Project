<?php
namespace app\model;

class Personnel
{
    private $id;
    private $nom;
    private $prenom;
    private $login;
    private $password;
    private $solde_conge;

    /**
     * @param $id
     * @param $nom
     * @param $prenom
     * @param $login
     * @param $password
     * @param $solde_conge
     */
    public function __construct($id, $nom, $prenom, $login, $password, $solde_conge)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->password = $password;
        $this->solde_conge = $solde_conge;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getSoldeConge()
    {
        return $this->solde_conge;
    }

    public function setSoldeConge($solde_conge)
    {
        $this->solde_conge = $solde_conge;
    }


}

?>
