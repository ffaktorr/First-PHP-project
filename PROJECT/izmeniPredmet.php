<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Izmena predmeta</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
<?php
require_once "class/Predmeti.php";
require_once "class/Korisnik.php";
session_start();

if(isset($_SESSION['ulogovan']) && $_SESSION['ulogovan']==true){

$korisnik=unserialize($_SESSION['korisnik']);

if($korisnik->tip=='admin' || $korisnik->tip=='saradnik'){

$id = $_GET['id'];
$predmet = Predmeti::ocitaj($id);
?>

<div id="login">
    <form id="form_login" method="post" action="">
        <label style="font-size: larger">Izmeni predmet</label><br>
        <?php if($korisnik->tip == 'admin'){ ?>
        <input type="text" name="naziv" value="<?php echo $predmet; ?>" size="37" required><br>
        <?php }else{ ?>
        <input style="opacity: 0.4" type="text" name="naziv" value="<?php echo $predmet; ?>" size="37" required readonly><br>
            <?php } ?>
        <textarea name="opis" cols="39" rows="5"><?php echo $predmet->opis_predmeta; ?></textarea><br>
        <input type="submit" value="Izmeni">


        <?php




        if (isset($_POST['naziv']) && $_POST['naziv'] != "") {

            $naziv = ($_POST['naziv']);

            $opis = ($_POST['opis']);

            $sql = "UPDATE predmeti SET naziv_predmeta='$naziv',opis_predmeta='$opis' WHERE id_predmeta='$id'";
            $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");

            if ($dbh->query($sql) === TRUE) {
                echo "<h1 style=' background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste izmenili predmet</font></h1>";
                if($korisnik->tip=="admin") {
                    header("refresh:2;url=azuriranje2.php");
                }else{
                    header("refresh:2;url=predmet.php?id=$id");
                }
            } else {
                echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>Greska prilikom povecivanja sa bazom</font></h1>";
            }
        }





        }
        }
    ?>


</form>
</div>
</body>
</html>