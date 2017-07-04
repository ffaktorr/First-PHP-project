<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LogIn</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">

</head>
<body>
<div id="login"> <form id="form_login" action="login.php" method="post" >
    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="submit" value="Log in!">
</form></div>

<?php

require_once "class/Korisnik.php";
require_once "class/Predmeti.php";
require_once "class/Saradnik.php";
require_once "class/Lab.php";
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = ($_POST['username']);
    $password = ($_POST['password']);

    $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
    $result = $dbh->query("SELECT ime,prezime,id_korisnika,tip FROM korisnici WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($result) == 1) {
        foreach ($result as $row)
            $korisnik = new Korisnik($row['ime'], $row['prezime'], $row['id_korisnika'], $row['tip']);
        echo "<p align='center'> Uspesno ste se ulogovali kao: <font color=\"red\">" . $korisnik->ime . " " . $korisnik->prezime . "</font><br>Bicete prebaceni na glavnu stranicu<br>ili kliknite <a href='index.php'> Ovde </a> da se vratite na glavnu stranu </p>";

        $_SESSION['korisnik']=serialize($korisnik);
        $_SESSION['ulogovan']=true;
        header("refresh:3;url=index.php");
        
    } else echo "<p align='center'><font color=\"red\">Pogresno korisnicko ime ili lozinka!!!<br>Ako ste zaboravili sifru kontaktiratje administratora(podaci se nalaze na pocetnoj strani)</font></p>";
}






?>



</body>
</html>

