<?php


class Saradnik
{
    private $id_korisnika;
    private $ime;
    private $prezime;
    private $email;
    private $bio;
    private $status;
    private $tip;
    private $slika;

    public function __construct($id_korisnika, $ime, $prezime, $email, $bio,$status,$tip,$slika)
    {
        $this->status=$status;
        $this->id_korisnika = $id_korisnika;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->email = $email;
        $this->bio = $bio;
        $this->tip=$tip;
        $this->slika=$slika;
    }

    public function __toString()
    {
        return $this->ime . " " . $this->prezime;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }

    public static function dohvati($id_korisnika)
    {
        $sql = "SELECT id_korisnika,ime,prezime,email,bio,status,tip,slika FROM korisnici WHERE id_korisnika IN (SELECT id_korisnika FROM vezbe WHERE id_korisnika=$id_korisnika)";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $res = $dbh->query($sql);
        $result = mysqli_fetch_array($res);
        $temp = new Saradnik($result['id_korisnika'], $result['ime'], $result['prezime'], $result['email'], $result['bio'],$result['status'],$result['tip'],$result['slika']);

        return $temp;

    }

    public static function ocitaj($id)
    {

        $sql = "SELECT * FROM korisnici WHERE id_korisnika=$id";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $res = $dbh->query($sql);
        $result = mysqli_fetch_array($res);
        $temp = new Saradnik($result['id_korisnika'], $result['ime'], $result['prezime'], $result['email'], $result['bio'],$result['status'],$result['tip'],$result['slika']);

        return $temp;
    }

    public static function poPredmetu($id_predmeta)
    {

        $sql = "SELECT * FROM korisnici WHERE tip='saradnik' AND id_korisnika IN (SELECT id_korisnika FROM veza_predmet_korisnik WHERE id_predmeta='$id_predmeta')";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        $niz = [];
        foreach ($result as $row) {
            array_push($niz, new Saradnik($row['id_korisnika'], $row['ime'], $row['prezime'], $row['email'], $row['bio'], $row['status'],$row['tip'],$row['slika']));

        }
        return $niz;
    }

    public static function provera_saradnika($id_korisnika, $id_predmeta)
    {

        $sql = "SELECT * FROM veza_predmet_korisnik WHERE id_korisnika=$id_korisnika AND id_predmeta=$id_predmeta ";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }
    }
    public static function provera_saradnika_status($id_korisnika){

        $sql = "SELECT * FROM korisnici WHERE id_korisnika=$id_korisnika AND status=1 ";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }


    }
    public static function provera_saradnika_lab($id_korisnika, $id_vezbe){

        $sql = "SELECT * FROM vezbe WHERE id_korisnika=$id_korisnika AND id_vezbe=$id_vezbe ";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            return false;
        }

    }

    public static function izlistaj()
    {

        $sql = "SELECT * FROM korisnici WHERE tip='saradnik'";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        $niz = [];
        foreach ($result as $row) {
            array_push($niz, new Saradnik($row['id_korisnika'], $row['ime'], $row['prezime'], $row['email'], $row['bio'], $row['status'],$row['tip'],$row['slika'] ));

        }
        return $niz;
    }

    public static function izlistajSVE()
    {

        $sql = "SELECT * FROM korisnici ORDER BY ime ASC";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        $niz = [];
        foreach ($result as $row) {
            array_push($niz, new Saradnik($row['id_korisnika'], $row['ime'], $row['prezime'], $row['email'], $row['bio'],$row['status'],$row['tip'],$row['slika']));

        }
        return $niz;
    }
}