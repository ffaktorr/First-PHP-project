<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
require_once "class/Lab.php";

$id=$_GET['id'];

$lab=Lab::ocitaj($id);


echo "<div style='position: center'>";

$sql1 = "DELETE FROM vezbe WHERE id_vezbe='$id'";
$sql2 = "DELETE FROM docs WHERE id_vezbe='$id'";
$dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
if ($dbh->query($sql1) == TRUE) {

    $dbh->query($sql2);
    echo "<h1 style='margin-top: 500px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste obrisali vezbu</font></h1>";
    header("refresh:3;url=predmet.php?id=$lab->id_predmeta");

}else
    echo "<h1 style='margin-top: 500px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Doslo je do greske</font></h1>";



echo "</div>";
?>

</body>
</html>