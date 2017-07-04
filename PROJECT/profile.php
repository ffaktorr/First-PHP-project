<!doctype html>
<html lang="en">
<head>
    <?php
    require_once "class/Predmeti.php";
    require_once "class/Lab.php";
    require_once "class/Saradnik.php";
    require_once "class/Korisnik.php";
    require_once "class/Slika.php";
    session_start();

if(isset($_GET['id']) && $_GET['id']!=""){
    $id = $_GET['id'];
    $provera = false;
    if (isset($_SESSION['ulogovan']) and $_SESSION['ulogovan'] == true) {

        $korisnik = unserialize($_SESSION['korisnik']);

        if ($id == $korisnik->id_korisnika) {
            $provera = true;
        }

    }


    $profil = Saradnik::ocitaj($id);
    $predmeti = Predmeti::poSaradniku($id);


    ?>
    <meta charset="UTF-8">
    <title><?php echo $profil->ime . " " . $profil->prezime ?></title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
<a style="position: absolute" href="index.php">Pocetna</a>

<?php

echo "<br>";
if($profil->slika=="nema") {
    echo "<h1 style='background-color: aquamarine; color: crimson' align='center'>" . $profil . "<br><img style='width:125px;height:125px'  src='images/default.jpg'> </h1>";
}
if($profil->slika=="ima") {
    echo "<h1 style='background-color: aquamarine; color: crimson' align='center'>" . $profil . "<br><img style='width:125px;height:125px'  src='prikaziSliku.php?id=$profil->id_korisnika'> </h1>";
}


if ($provera) {
    echo "<pre><div align='center'><a style='align='center' href='izmeniKorisnika.php?id=$profil->id_korisnika'>izmeni profil</a>";
    echo " <a style='align='center' href='izmeniSifru.php?id=$profil->id_korisnika'>promeni sifru</a></div></pre>";

}


?>
<br>
<div id="tabela_index">
    <table id="table" align="center" border="1">
        <tr>
            <td>
                <p align="center"><?php echo "<b>Biografija:</b>"; ?> </p>
                <p align="center"><?php echo $profil->bio; ?> </p>
                <br>
            </td>
        </tr>
    </table>
</div>
<div style="float: left; margin-left: 400px">


    <p><b>Kontakt:</b></p>
    <p style="background-color: #dddddd"><b>Email</b> : <?php echo $profil->email; ?></p>


</div>

<div style="float: right; margin-right: 400px">


    <p><b>Predmeti na kojima je angazovan:</b></p>
    <ul>
        <?php
        if($profil->status=='1'){
        foreach ($predmeti as $p) {
            echo "<li> <a href='predmet.php?id=$p->id_predmeta'>" . $p . "</a></li>";

        }}

        }else
            header("refresh:0;url=index.php");
        ?>
    </ul>




</div>

</body>
</html>



