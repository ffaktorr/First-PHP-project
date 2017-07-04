<?php


$id=$_GET['id'];
$id2=$_GET['id2'];


$sql="DELETE FROM docs WHERE id_doc='$id'";
$dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
if ($dbh->query($sql) == TRUE) {
    echo "<h1 style='margin-top: 500px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste obrisali dokument</font></h1>";
    header("refresh:3;url=vezba.php?id=$id2");
}else {
    echo "<font  color='red'>Greska</font>";
}