<!doctype html>
<html lang="en">
<head>
    <script type="text/javascript" src="jquery/jquery-3.1.0.js"></script>
    <?php
    require_once "class/Predmeti.php";
    require_once "class/Lab.php";
    require_once "class/Saradnik.php";
    require_once "class/Korisnik.php";
    session_start();
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $predmet = Predmeti::ocitaj($id);
    $vezbe = Lab::ispis($predmet->id_predmeta);
    $saradnici = Saradnik::poPredmetu($predmet->id_predmeta);
    $provera1 = false;
    $provera2 = false;

    
    

    if (isset($_SESSION['ulogovan']) && $_SESSION['ulogovan'] == true) {
        $korisnik = unserialize($_SESSION['korisnik']);
        
        $provera1 = Saradnik::provera_saradnika($korisnik->id_korisnika, $predmet->id_predmeta);
        $provera2 = Saradnik::provera_saradnika_status($korisnik->id_korisnika);
    }
    ?>

    <meta charset="UTF-8">
    <title><?php echo $predmet->naziv_predmeta; ?></title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
  
</head>
<body>
<?php

echo "<a href='index.php'>Pocetna</a><br>";



?>



<h1 style="background-color: antiquewhite; color: crimson" align="center"><?php echo $predmet->naziv_predmeta ?></h1>


<div align="center">
    <p><?php echo $predmet->opis_predmeta; ?></p>

    <?php

    if ($provera1 && $provera2) {
    ?>
    <input type="button" onclick="location.href='izmeniPredmet.php?id=<?php echo $predmet->id_predmeta ?>';"
           value="Izmeni predmet"/>
    <input type="button" onclick="location.href='dodajVezbu.php?id=<?php echo $predmet->id_predmeta ?>';"
           value="Dodaj vezbu"/>
</div>

<?php
}
?>

<div id="parent" style="float: left">

    <ul>
        Vezbe:
        <?php
        foreach ($vezbe as $v) {
            $date = date_create($v->datum);
            echo "<li>" . date_format($date, "d.m.Y H:i") . " <a href='vezba.php?id=$v->id_vezbe'>" . $v->naziv_vezbe . "</a>";
        }
        ?>
    </ul>
</div>

<div id="parent2" style="float: right">

    <ul>
        Saradnici:
        <?php
        foreach ($saradnici as $s) {
            if($s->status == 1)
            echo "<li> <a href='profile.php?id=$s->id_korisnika'>" . $s . "</a></li>";
        }
        }else
        header("refresh:0;url=index.php");
        ?>

    </ul>

</div>

</body>
</html>
