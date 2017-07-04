<?php
$id=$_GET['id'];
$sql="SELECT * FROM slike WHERE id_korisnika='$id'";
$dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
$result = $dbh->query($sql);
$res=mysqli_fetch_array($result);

$slika=$res['slika'];

header("content-type: image/jpeg");
echo $slika;






