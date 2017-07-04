<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Izmena predmeta</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
<?php
require_once "class/Saradnik.php";
require_once "class/Korisnik.php";
require_once "class/usernamePassword.php";
session_start();

if(isset($_SESSION['ulogovan']) && $_SESSION['ulogovan']==true){

$korisnik = unserialize($_SESSION['korisnik']);

if ($korisnik->tip == 'admin' || $korisnik->tip == 'saradnik') {



    $id = $_GET['id'];

    $korisnik2 = Saradnik::ocitaj($id);
    $loginInfo = usernamePassword::dohvati($id);
    if (($korisnik->id_korisnika == $korisnik2->id_korisnika) || $korisnik->tip == "admin"){

    ?>
    <a href="index.php">Pocetna</a> <a href="profile.php?id=<?php echo $id; ?>">Profil</a>


    <div id="login2">
        <form id="form_login" method="post" action="izmeniKorisnika.php?id=<?php echo $id; ?>" style="">
            <?php
            if ($korisnik2->slika == "ima") {
                ?>
                <img style="width: 125px;height: 125px"
                     src="prikaziSliku.php?id=<?php echo $korisnik2->id_korisnika; ?>"><br>

                <?php
            } else {
                ?><img style='width:125px;height:125px' src='images/default.jpg'><br>
                <?php
            }
            ?>
            <label style="font-size: larger">Izmeni korisnika</label><br>
            <?php if ($korisnik->tip == 'admin') { ?>
                <label>Ime</label>
                <input type="text" name="ime" value="<?php echo $korisnik2->ime; ?>" size="37" required><br>
                <label>Prezime</label>
                <input type="text" name="prezime" value="<?php echo $korisnik2->prezime; ?>" size="37" required><br>
                <label>Email</label>
                <input type="text" name="email" value="<?php echo $korisnik2->email; ?>" size="37" required><br>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $loginInfo->username; ?>" size="37" required><br>
                <label>Password</label>
                <input type="text" name="password" value="<?php echo $loginInfo->password; ?>" size="37" required><br>
                <label>Tip</label>
                <select name="tip">
                    <?php
                    if ($korisnik2->tip == "admin") {
                        echo "<option selected value='admin'>Admin</option>";
                        echo "<option value='saradnik'>Saradnik</option>";
                        echo "<option value='korisnik'>Korisnik</option>";

                    } elseif ($korisnik2->tip == "saradnik") {
                        echo "<option value='admin'>Admin</option>";
                        echo "<option selected value='saradnik'>Saradnik</option>";
                        echo "<option value='korisnik'>Korisnik</option>";
                    } else {
                        echo "<option value='admin'>Admin</option>";
                        echo "<option value='saradnik'>Saradnik</option>";
                        echo "<option selected value='korisnik'>Korisnik</option>";
                    }
                    echo "</select><br>";

                    ?>
                </select>
                <label>Biografija</label>
                <textarea name="opis" cols="39" rows="5"
                          placeholder="Biografija..."><?php echo $korisnik2->bio; ?></textarea><br>

                <input type="submit" value="Izmeni" name="submit1" id="izmeniKorisnikaDugme">

            <?php } else { ?>


                <textarea name="opis" cols="39" rows="5"
                          placeholder="Biografija..."><?php echo $korisnik2->bio; ?></textarea><br>

                <input type="submit" name="submit2" value="Izmeni" id="izmeniKorisnikaDugme">
            <?php } ?>
        </form>
    </div>
    <?php


    if (isset($_POST['submit1'])) {
        if (isset($_POST['ime']) && isset($_POST['prezime']) && isset($_POST['email']) && isset($_POST['tip']) && isset($_POST['username']) && isset($_POST['password'])) {
            if (($_POST['ime'] != "") && ($_POST['prezime'] != "") && ($_POST['email'] != "") && ($_POST['tip'] != "") && ($_POST['username'] != "") && ($_POST['password'] != "")) {


                $ime = ($_POST['ime']);
                $prezime = ($_POST['prezime']);
                $email = ($_POST['email']);
                $tip = ($_POST['tip']);
                $opis = ($_POST['opis']);
                $username = ($_POST['username']);
                $password = ($_POST['password']);


                $sql = "UPDATE korisnici SET ime='$ime',prezime='$prezime',email='$email',tip='$tip',bio='$opis',username='$username',password='$password' WHERE id_korisnika='$id'";
                $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");

                if ($dbh->query($sql) === TRUE) {
                    echo "<h1 style=' background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste izmenili korisnika</font></h1>";

                    header("refresh:2;url=azuriranje2.php");
                } else {
                    echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Greska prilikom povecivanja sa bazom</font></h1>";
                }


            }
        }
    }
    if (isset($_POST['submit2'])) {
        if (isset($_POST['opis']) && $_POST['opis'] != "") {


            $opis = ($_POST['opis']);


            $sql = "UPDATE korisnici SET bio='$opis' WHERE id_korisnika='$id'";
            $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");

            if ($dbh->query($sql) === TRUE) {
                echo "<h1 style=' background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste izmenili korisnika</font></h1>";

                header("refresh:2;url=profile.php?id=$id");
            } else {
                echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Greska prilikom povecivanja sa bazom</font></h1>";
            }


        }

    }

}else
        header("refresh:0;url=index.php");

}

if (($korisnik->id_korisnika == $korisnik2->id_korisnika) || $korisnik->tip == "admin"){
?>

<br>

<div align="center">
    <form action="" method="post"
          enctype="multipart/form-data">
        Promeni sliku (mora biti jpg/jpeg format):<br>
        <input type="file" name="slika"> <input name="submit" type="submit" value="Upload">

        <?php
        if (isset($_POST['submit'])) {
            if (isset($_FILES['slika'])) {


                $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");

                $slikaNaziv = mysqli_real_escape_string($dbh, $_FILES['slika']['name']);
                $slikaSadrzaj = mysqli_real_escape_string($dbh, file_get_contents($_FILES['slika']['tmp_name']));
                $slikaType = $_FILES['slika']['type'];


                $sql = "SELECT * FROM slike WHERE id_korisnika='$korisnik2->id_korisnika'";
                $sql2 = "UPDATE slike SET naziv_slike='$slikaNaziv',slika='$slikaSadrzaj' WHERE id_korisnika='$korisnik2->id_korisnika'";
                $sql3 = "INSERT INTO slike VALUES ('','$slikaNaziv','$slikaSadrzaj','$korisnik2->id_korisnika')";
                $result = $dbh->query($sql);

                if (substr($slikaType, 0, 5) == "image") {
                    if (mysqli_num_rows($result) == 0) {

                        mysqli_query($dbh, $sql3);
                        $dbh->query("UPDATE korisnici SET slika='ima' WHERE id_korisnika='$korisnik2->id_korisnika'");

                    } else {
                        mysqli_query($dbh, $sql2);

                    }

                } else {
                    echo "Mozete uplodovati samo slike";
                }


            }
        }
        }
        }else
        {
            header("refresh:0;url=index.php");
        }
    ?>

</form>
</div>


</body>
</html>

<script type="text/javascript" src="jquery/jquery-3.1.0.js"></script>
<script type="text/javascript" src="jquery/script.js"></script>