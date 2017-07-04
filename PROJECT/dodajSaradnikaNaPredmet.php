<?php
if(isset($_POST['opcija_saradnik']) && $_POST['opcija_saradnik']=="+") {
    if (isset($_POST['predmet']) && isset($_POST['saradnik'])) {
        $predmet = ($_POST['predmet']);
        $saradnik = ($_POST['saradnik']);


        $sql1 = "SELECT * FROM veza_predmet_korisnik WHERE (id_korisnika='$saradnik' AND id_predmeta='$predmet')";
        $sql2 = "INSERT INTO veza_predmet_korisnik (id_korisnika, id_predmeta) VALUES ('$saradnik','$predmet') ";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql1);

        if (mysqli_num_rows($result) == 1) {
            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Taj saradnik je vec na tom predmetu</font></h1>";
            header("refresh:2;url=azuriranje2.php");

        } elseif ($dbh->query($sql2) === TRUE) {

            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste dodali predmet saradnika predmet</font></h1>";
            header("refresh:2;url=azuriranje2.php");
        }
    }
}

if(isset($_POST['opcija_saradnik']) && $_POST['opcija_saradnik']=="-") {
    if (isset($_POST['predmet']) && isset($_POST['saradnik'])) {
        $predmet = ($_POST['predmet']);
        $saradnik = ($_POST['saradnik']);


        $sql1 = "SELECT * FROM veza_predmet_korisnik WHERE (id_korisnika='$saradnik' AND id_predmeta='$predmet')";
        $sql2 = "DELETE FROM veza_predmet_korisnik WHERE  id_korisnika=$saradnik";
        $sql3 = "UPDATE vezbe SET id_korisnika=NULL WHERE id_korisnika='$saradnik'";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result = $dbh->query($sql1);

        if (mysqli_num_rows($result) == 0) {
            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Taj saradnik nije na tom predmetu</font></h1>";
            header("refresh:2;url=azuriranje2.php");

        } elseif ($dbh->query($sql2) === TRUE) {

            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste obrisali saradnika sa predmeta</font></h1>";
            header("refresh:2;url=azuriranje2.php");
        }
    }
}