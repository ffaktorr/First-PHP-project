<?php
require_once "class/Saradnik.php";


$id=$_GET['id'];
$status=$_GET['s'];
var_dump($status);



$korisnik=Saradnik::dohvati($id);

echo "<div style='position: center'>";
$sql1 = "UPDATE korisnici SET status=1 WHERE korisnici.id_korisnika='$id'";
$sql2 = "UPDATE korisnici SET status=0 WHERE korisnici.id_korisnika='$id'";
$dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
if ($status == '1') {
    
    $dbh->query($sql2);
    header("refresh:0;url=azuriranje2.php");

} else {
    
    $dbh->query($sql1);
    header("refresh:0;url=azuriranje2.php");
    
}


?>