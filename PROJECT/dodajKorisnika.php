<?php


if (isset($_POST['ime']) && isset($_POST['prezime']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['tip'])) {
    if ($_POST['ime'] != "" && $_POST['prezime'] != "" && $_POST['username'] != "" && $_POST['password'] != "" && $_POST['email'] != "" && $_POST['tip'] != "") {

        $ime = ($_POST['ime']);
        $prezime = ($_POST['prezime']);
        $email = ($_POST['email']);
        $username = ($_POST['username']);
        $password = ($_POST['password']);
        $tip = ($_POST['tip']);

        $sql1 = "SELECT email FROM korisnici WHERE email='$email'";
        $sql2 = "SELECT username FROM korisnici WHERE username='$username'";
        $sql3 = "INSERT INTO korisnici (id_korisnika, ime,prezime,username,password,email,tip,slika) VALUES (NULL, '$ime', '$prezime','$username','$password','$email','$tip','nema')";
        $sql4 = "SELECT * FROM korisnici WHERE email='$email' AND status=0 ";
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
        $result1 = $dbh->query($sql1);
        $result2 = $dbh->query($sql2);
        $result3 = $dbh->query($sql4);
        if (mysqli_num_rows($result1) == 1) {
            if (mysqli_num_rows($result3) == 1){
                echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Unosite korisnika koji vec postoji ali je neaktivan<br>Aktivirajte ga!</font></h1>";

            }else {
                echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Unosite korisnika koji vec postoji<br>Pokusajte ponovo</font></h1>";
                 header("refresh:2;url=azuriranje2.php");
            }
        } elseif (mysqli_num_rows($result2) == 1) {
            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Izabrano korisnicko ime vec postoji<br>Pokusajte ponovo</font></h1>";
            header("refresh:3;url=azuriranje2.php");

        } elseif ($dbh->query($sql3) === TRUE) {
            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste dodali korisnika</font></h1>";

            header("refresh:3;url=azuriranje2.php");

        } else {
            echo "<font  color='red'>Greska prilikom dodavanja korisnika.Kontaktirajte administratora pre nastavka sa radom!!!</font>";

        }


    }
}