<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
require_once "class/Predmeti.php";


$id=$_GET['id'];

$predmet=Predmeti::ocitaj($id);

echo "<div style='position: center'>";
$sql = "DELETE FROM predmeti WHERE id_predmeta='$id'";
$sql2 = "DELETE FROM vezbe WHERE id_predmeta='$id'";
$sql3 = "DELETE FROM veza_predmet_saradnik WHERE id_predmeta='$id'";
$dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
if ($dbh->query($sql) === TRUE) {
    $dbh->query($sql2);
    $dbh->query($sql3);
            echo "<h1 style='margin-top: 500px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste obrisali predmet</font></h1>";
            header("refresh:3;url=azuriranje2.php");


        
    }else {
    echo 'Error! Failed to insert the file'
        . "<pre>{$dbh->error}</pre>";
}
echo "</div>";
?>

</body>
</html>