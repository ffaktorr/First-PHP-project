<?php

/**
 * Created by PhpStorm.
 * User: stefi
 * Date: 03-Aug-16
 * Time: 10:24 PM
 */
class Predmeti
{
    private $id_predmeta;
    private $naziv_predmeta;
    private $opis_predmeta;

    public function __construct($id_predmeta, $naziv_predmeta, $opis_predmeta)
    {
        $this->id_predmeta = $id_predmeta;
        $this->naziv_predmeta = $naziv_predmeta;
        $this->opis_predmeta = $opis_predmeta;

    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }

    public function __toString()
    {
        return $this->naziv_predmeta;
    }

    public static function dohvati()
    {
        $sql = "SELECT * FROM predmeti ORDER BY naziv_predmeta ASC";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        $niz = [];
        foreach ($result as $row) {
            array_push($niz, new Predmeti($row['id_predmeta'], $row['naziv_predmeta'], $row['opis_predmeta']));
        }
        return $niz;
    }

    public static function ocitaj($id)
    {

        $sql = "SELECT * FROM predmeti WHERE id_predmeta=$id";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $res = $dbh->query($sql);
        $result = mysqli_fetch_array($res);
        $temp = new Predmeti($result['id_predmeta'], $result['naziv_predmeta'], $result['opis_predmeta']);

        return $temp;
    }

    public static function poSaradniku($id)
    {
        $sql = "SELECT * FROM predmeti WHERE id_predmeta IN(SELECT id_predmeta FROM veza_predmet_korisnik WHERE id_korisnika='$id') ORDER BY naziv_predmeta ASC";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        
        $niz = [];
        foreach ($result as $row) {
            array_push($niz, new Predmeti($row['id_predmeta'], $row['naziv_predmeta'], $row['opis_predmeta']));
        }
        return $niz;

    }
}