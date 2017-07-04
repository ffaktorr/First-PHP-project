<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pocetna</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    <link rel="stylesheet" type="text/css" href="style/navigacija.css">
</head>
<body>

<?php
require_once "class/Korisnik.php";
require_once "class/Predmeti.php";
require_once "class/Saradnik.php";
require_once "class/Lab.php";
session_start();


$predmeti = Predmeti::dohvati();

$day = date('D');
$danas1=date('Y-m-d');
$danas11=date('d-m-Y');

echo "<br>";
if ($day=='Sat' || $day=='Sun') {

    $temp1 = date('Y-m-d', strtotime('next monday'));
    $temp11 = date('d.m.Y', strtotime('next monday'));
    $temp2= date('Y-m-d', strtotime('next saturday'));
    $temp22= date('d.m.Y', strtotime('next friday'));

}elseif($day=='Fri') {
    $temp1 = date('Y-m-d', strtotime('last monday'));
    $temp11 = date('d.m.Y', strtotime('last monday'));
    $temp2= date('Y-m-d', strtotime('next saturday'));
    $temp22 = $danas11;

}elseif ($day=='Mon') {
    $temp1 = $danas1;
    $temp11 = $danas11;
    $temp2 = date('Y-m-d', strtotime('next saturday'));
    $temp22 = date('d.m.Y', strtotime('next friday'));


}else{
    $temp1 = date('Y-m-d', strtotime('last monday'));
    $temp11 = date('d.m.Y', strtotime('last monday'));
    $temp2 = date('Y-m-d', strtotime('next saturday'));
    $temp22 = date('d.m.Y', strtotime('next friday'));

}
?>

<?php

if (isset($_SESSION['ulogovan']) && $_SESSION['ulogovan']== true) {
    $korisnik=unserialize($_SESSION['korisnik']);
    echo "Ulogovani ste kao : <a href='profile.php?id=$korisnik->id_korisnika'> ".$korisnik->ime." ".$korisnik->prezime."</a>";
    echo "<br> <a href='logout.php'>Logout</a> ";
if($korisnik->tip == 'admin') {
    echo "<br><a href='azuriranje2.php'>Azuriranje</a>";
}



}else
{
    echo "<br><a href='login.php'>login</a>";
}


?>
<br><br><br><br><br><br>

<div id="tabela_index" align="center">
    <table border="1" id="table">
        <thead>
            <font style="font-size: larger">Laboratorijse vezbe za nedelju: <?php echo $temp11; ?> - <?php echo $temp22;?> i saradnici koji ce raditi na njima</font>
        </thead>
        <tbody >
        <?php

        foreach ($predmeti as $p) {
            $pom=$p->id_predmeta;
            echo "<tr id='tr' ><td id='td'><a href='predmet.php?id=$p->id_predmeta'>" . $p . "</a><br>";

            $lab = Lab::dohvati($p->id_predmeta,$temp1,$temp2);

                if($lab==true){
                    echo $lab . "</td><td id='td'>";
                $saradnici = Saradnik::dohvati($lab->id_korisnika);
                    if($saradnici->status==1) {
                        echo "<b>Saradnik:</b><br><a href='profile.php?id=$saradnici->id_korisnika'>" . $saradnici . "<br>";
                    }else{
                        echo "<b>Saradnik:</b><br> Trenutno na ovoj vezbi <br> ne radi ni jedan saradnik.<br>Bice dotato kasnije";
                    }
                }else
                    echo "Ove nedelje nema vezbi";

            echo "</td></tr>";

    }
    ?>
    </tbody>
    </table>
</div>


<br><br><br>
<br>

</body>
<footer><div align="center">
        <p>Administrator: Stefan Petrovic</p>
        <p>Kontakt: <a href="mailto:stefan.petrovc.1212@gmail.com">
            stefan.petrovic.1212@gmail.com</a>.</p>
        </div>
</footer>
</html>