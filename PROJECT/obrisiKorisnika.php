<?php
require_once "class/Saradnik.php";


$id=$_GET['id'];


$korisnik=Saradnik::ocitaj($id);


echo "<div style='position: center'>";

$sql = "DELETE FROM korisnici WHERE id_korisnika='$id'";
$sql2 = "DELETE FROM veza_predmet_saradnik WHERE id_korisnika='$id'";
$dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
if ($dbh->query($sql) == TRUE) {
    $dbh->query($sql2);

            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste obrisali korisnika</font></h1>";
            header("refresh:3;url=azuriranje2.php");

        } else {
    echo "<font  color='red'>Taj korisnik nepostoji</font>";

}
echo "</div>";
?>