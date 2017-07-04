<?php



if (isset($_POST['naziv']) && $_POST['naziv'] != "") {

    $naziv = ($_POST['naziv']);
    $opis = ($_POST['opis']);

    $sql1 = "SELECT naziv_predmeta FROM predmeti WHERE naziv_predmeta='$naziv'";
    $sql2 = "INSERT INTO predmeti (id_predmeta, naziv_predmeta, opis_predmeta) VALUES (NULL, '$naziv', '$opis')";
    $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
    $result = $dbh->query($sql1);
    if (mysqli_num_rows($result) == 1) {
        echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Unosite predmet koji vec postoji<br>Pokusajte ponovo</font></h1>";
        header("refresh:2;url=azuriranje2.php");

    } elseif ($dbh->query($sql2) === TRUE) {
        echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste dodali predmet predmet</font></h1>";
        header("refresh:2;url=azuriranje2.php");
    } else {
        echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Greska prilikom povecivanja sa bazom</font></h1>";
    }
}