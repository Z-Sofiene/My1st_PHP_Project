<?php

namespace app\model;
class Conge
{
    private $id;
    private $personnel_id;
    private $debut_conge;
    private $fin_conge;
    private $validConge;

    public function __construct($id, $personnel_id, $debut_conge, $fin_conge)
    {
        $this->id = $id;
        $this->personnel_id = $personnel_id;
        $this->debut_conge= $debut_conge;
        $this->fin_conge = $fin_conge;
        $this->validConge = null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getPersonnelId()
    {
        return $this->personnel_id;
    }

    public function setPersonnelId($personnel_id)
    {
        $this->personnel_id = $personnel_id;
    }

    public function getDebutConge()
    {
        return $this->debut_conge;
    }

    public function setDebutConge($debut_conge)
    {
        $this->debut_conge = $debut_conge;
    }

        public function getFinConge()
    {
        return $this->fin_conge;
    }

    public function setFinConge($fin_conge)
    {
        $this->fin_conge = $fin_conge;
    }

    public function getValidConge()
    {
        return $this->validConge;
    }

    public function setValidConge(bool $validConge)
    {
        $this->validConge = $validConge;
    }
}

?>