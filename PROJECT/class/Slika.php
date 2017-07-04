<?php

class Slika
{
    private $id_slike;
    private $naziv_slike;
    private $slika;
    private $id_korisnika;

    public function __construct($id_slike, $naziv_slike, $slika, $id_korisnika)
    {
        $this->id_slike = $id_slike;
        $this->naziv_slike = $naziv_slike;
        $this->slika = $slika;
        $this->id_korisnika = $id_korisnika;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }

}