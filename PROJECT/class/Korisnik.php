<?php


class Korisnik
{

    private $ime;
    private $prezime;
    private $id_korisnika;
    private $tip;
    
    


    public function __construct($ime,$prezime,$id_korisnika,$tip)
    {
        $this->ime=$ime;
        $this->prezime=$prezime;
        $this->id_korisnika=$id_korisnika;
        $this->tip=$tip;
    }

    public function __get($name)
    {
       return isset($this->$name) ? $this->$name : "";
    }

    
}