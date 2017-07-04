<?php

class Lab
{
    private $id_vezbe;
    private $datum;
    private $opis;
    private $lab;
    private $naziv_vezbe;
    private $id_predmeta;
    private $id_korisnika;

    public function __construct($id_vezbe,$datum,$opis,$lab,$naziv_vezbe,$id_predmeta,$id_korisnika)
    {
        $this->id_vezbe=$id_vezbe;
        $this->datum=$datum;
        $this->opis=$opis;
        $this->lab=$lab;
        $this->naziv_vezbe=$naziv_vezbe;
        $this->id_predmeta=$id_predmeta;
        $this->id_korisnika=$id_korisnika;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }

    
    public function __toString()
    {
//        date_format($date,"Y/m/d H:i:s")
        $date=date_create($this->datum);
        return "<b>Datum: </b>".date_format($date,"d.m.Y H:i")."<br><b>Laboratorija: </b>".$this->lab."<br> <a href='vezba.php?id=$this->id_vezbe'>".$this->naziv_vezbe."</a>";
    }

    public static function dohvati($id_predmeta,$date1,$date2)
    {   

        $sql = "SELECT * FROM vezbe WHERE id_predmeta=$id_predmeta AND datum BETWEEN '$date1' and '$date2'";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $temp = new Lab($row['id_vezbe'], $row['datum'], $row['opis'], $row['lab'], $row['naziv_vezbe'], $row['id_predmeta'], $row['id_korisnika']);
            return $temp;
        }
    }

    public static function ispis($id_predmeta){

        $sql = "SELECT * FROM vezbe WHERE id_predmeta=$id_predmeta ORDER BY vezbe.datum ASC ";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        $niz = [];
        foreach($result as $row) {
            array_push($niz, new Lab($row['id_vezbe'],$row['datum'],$row['opis'] , $row['lab'], $row['naziv_vezbe'], $row['id_predmeta'], $row['id_korisnika']));
        }
        return $niz;


    }

    public static function ocitaj($id){

        $sql = "SELECT * FROM vezbe WHERE id_vezbe=$id";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql);
        $row = mysqli_fetch_array($result);
        $temp= new Lab($row['id_vezbe'],$row['datum'],$row['opis'] , $row['lab'], $row['naziv_vezbe'], $row['id_predmeta'], $row['id_korisnika']);

        return $temp;
    }



}