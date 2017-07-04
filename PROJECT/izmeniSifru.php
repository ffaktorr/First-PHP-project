
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LogIn</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">

</head>
<body>

<?php
require_once "class/Korisnik.php";
require_once "class/Saradnik.php";
require_once "class/usernamePassword.php";
session_start();

if(isset($_GET['id']) && $_GET['id']!="") {
    $id = $_GET['id'];
    $korisnik2 = Saradnik::ocitaj($id);


    if (isset($_SESSION['ulogovan']) && $_SESSION['ulogovan'] == true) {

        $korisnik = unserialize($_SESSION['korisnik']);


        if ($korisnik->id_korisnika == $korisnik2->id_korisnika) {
            $loginInfo= usernamePassword::dohvati($id);
            ?>


            <div id="login">
                <form id="form_login" action="" method="post">
                    <input type="password" name="stara" placeholder="Stara sifra" required><br>
                    <input type="password" name="nova" placeholder="Nova Sifra" required><br>
                    <input type="password" name="novaPotvrda" placeholder="Potrvrda nove sifre" required><br>
                    <input type="submit" name="izmeniSifru" value="Izmeni sifru!">
                </form>
            </div>


            <?php

            
            if(isset($_POST['izmeniSifru'])){
                if (isset($_POST['stara']) && isset($_POST['nova']) && isset($_POST['novaPotvrda'])){
                    if($_POST['stara'] == $loginInfo->password){
                        if($_POST['nova'] == $_POST['novaPotvrda']){
                            if($_POST['stara'] != $_POST['nova']) {

                                $sifra = $_POST['nova'];


                                $sql = "UPDATE korisnici SET password='$sifra' WHERE id_korisnika='$id'";
                                $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");

                                if ($dbh->query($sql) === TRUE) {
                                    echo "<h1 style=' background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste izmenili sifru</font></h1>";

                                    header("refresh:2;url=profile.php?id=$id");
                                } else {
                                    echo "<h1 style='margin-top: 50px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Greska prilikom povecivanja sa bazom</font></h1>";
                                }


                            }else  echo "<h1 style='margin-top: 50px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Unosite istu sifru koju sad koristite</font></h1>";
                        } else  echo "<h1 style='margin-top: 50px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Pogresna potvrda sifre</font></h1>";
                    }else  echo "<h1 style='margin-top: 50px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Pogresna sifra!!!</font></h1>";
                }
            }


        }else header("refresh:0;url=index.php");
    }else header("refresh:0;url=index.php");
}else header("refresh:0;url=index.php");

?>
</body>
</html>

