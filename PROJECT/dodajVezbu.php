<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
<?php

require_once "class/Predmeti.php";
require_once "class/Saradnik.php";
require_once "class/Korisnik.php";
session_start();
$id=$_GET['id'];

if(isset($_SESSION['ulogovan']) && $_SESSION['ulogovan']==true) {

    $korisnik = unserialize($_SESSION['korisnik']);

    if ($korisnik->tip == 'saradnik') {

        $provera = Saradnik::provera_saradnika($korisnik->id_korisnika, $id);
        $saradnici= Saradnik::poPredmetu($id);

        if ($provera) { ?>


            <div id="login2">
                <form id="form_login" method="post" action="">
                    <label style="font-size: larger;opacity:">Dodaj vezbu</label><br>
                    <input  type="text" placeholder="Naviv vezbe" name="naziv_vezbe"  size="37" required><br>
                    <input type="text" name="lab"  placeholder="Laboratorija" size="37" required><br>
                    <textarea name="opis" cols="39" rows="5" placeholder="Opis vezbe..." required></textarea><br>
                    <select name="saradnik" required>
                        <option selected disabled value="">Izaveri saradnika</option>
                        <?php
                        foreach ($saradnici as $s)
                            if($s->status==1)
                            echo "<option value='$s->id_korisnika'>$s</option>"
                        
                        ?>
                    </select>
                    <input type="datetime-local" name="datum" size="37" required><br><br>
                    <input type="submit" value="Dodaj" name="submit" id="dodajVezbuDugme">
                    
                </form>
            </div>
            
            <?php
            
            if(isset($_POST['naziv_vezbe']) && isset($_POST['lab']) && isset($_POST['opis']) && isset($_POST['saradnik']) && isset($_POST['datum'])) {
                if($_POST['naziv_vezbe']!= "" && $_POST['lab']!="" && $_POST['opis']!="" && $_POST['saradnik']!="" && $_POST['datum']!=""){


                    $naziv = ($_POST['naziv_vezbe']);
                    $lab = ($_POST['lab']);
                    $opis = ($_POST['opis']);
                    $saradnik = ($_POST['saradnik']);
                    $datum = ($_POST['datum']);

                    $sql = "INSERT INTO vezbe (id_vezbe,datum,opis,lab,naziv_vezbe,id_predmeta,id_korisnika) VALUES (NULL, '$datum', '$opis','$lab','$naziv','$id','$saradnik')";
                    $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
                    if ($dbh->query($sql) === TRUE) {
                        echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste dodali vezbu</font></h1>";
                        header("refresh:3;url=predmet.php?id=$id");

                    } else {
                        echo "<font  color='red'>Greska prilikom dodavanja korisnika.Kontaktirajte administratora pre nastavka sa radom!!!</font>";

                    }
                    
                }
            }
            
            
        }
    }
}
?>

</body>
</html>

<script type="text/javascript" src="jquery/jquery-3.1.0.js"></script>
<script type="text/javascript" src="jquery/script.js"></script>