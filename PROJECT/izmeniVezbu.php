<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
</head>
<body>
<?php
require_once "class/Predmeti.php";
require_once "class/Saradnik.php";
require_once "class/Korisnik.php";
require_once "class/Lab.php";
session_start();
$id=$_GET['id'];

$lab=Lab::ocitaj($id);
$trenutni=Saradnik::dohvati($lab->id_korisnika);
$saradnici=Saradnik::poPredmetu($lab->id_predmeta);

if(isset($_SESSION['ulogovan']) && $_SESSION['ulogovan']==true) {

    $korisnik = unserialize($_SESSION['korisnik']);

    if ($korisnik->tip == 'saradnik') {
            
        $provera = Saradnik::provera_saradnika_lab($korisnik->id_korisnika, $id);

        if ($provera) { ?>


            <div id="login2">
                <form id="form_login" method="post" action="">
                    <label style="font-size: larger">Izmeni vezbu</label><br>
                    <labe>Naziv vezbe</labe>
                    <input type="text" placeholder="Naviv vezbe" name="naziv_vezbe" value="<?php echo $lab->naziv_vezbe?>"  size="37" required><br>
                    <label>Laboratorija</label>
                    <input type="text" name="lab"  placeholder="Laboratorija" size="37" value="<?php echo $lab->lab?>" required><br>
                    <label>Datum odrzavanja</label>
                    <input type="text" name="vreme" placeholder="Vreme" size="37" value="<?php echo $lab->datum ?>" required><br>
                    <label>Opis vezbe </label>
                    <textarea name="opis" cols="39" rows="5" placeholder="Opis vezbe..."  required><?php echo $lab->opis?></textarea><br>
                    <select name="saradnik" required>
                        <option selected  value="<?php echo $trenutni->id_korisnika?>"<"><?php echo $trenutni; ?></option>
                        <?php
                        foreach ($saradnici as $s) {
                            if ($trenutni!=$s) {
                                echo "<option value='$s->id_korisnika'>$s</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" value="Izmeni" name="submit" id="izmeniVezbuDugme">

                </form>
            </div>


    <?php



            if(isset($_POST['naziv_vezbe']) && isset($_POST['lab']) && isset($_POST['vreme']) && isset($_POST['opis']) && isset($_POST['saradnik'])) {
                if($_POST['naziv_vezbe']!= "" && $_POST['lab']!="" && $_POST['vreme']!="" && $_POST['opis']!="" && $_POST['saradnik']!=""){


                    $naziv = ($_POST['naziv_vezbe']);
                    $lab = ($_POST['lab']);
                    $datum=($_POST['vreme']);
                    $opis = ($_POST['opis']);
                    $saradnik = ($_POST['saradnik']);



                    $sql = "UPDATE vezbe SET opis='$opis',lab='$lab',datum='$datum',naziv_vezbe='$naziv',id_korisnika='$saradnik' WHERE id_vezbe='$id'";

                    $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");
                    $result=$dbh->query($sql);


                    if ($dbh->query($sql) === TRUE) {
                        echo "<h1 style='margin-top: 200px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste izmenili vezbu</font></h1>";
                        header("refresh:3;url=vezba.php?id=$id");


                    } else {
                        echo "<font  color='red'>Greska prilikom izmene vezbe.Kontaktirajte administratora pre nastavka sa radom!!!</font>"
                        . "<pre>{$dbh->error}</pre>";
                    }

                }
            }










        }
    }
}
?>

</body>
</html>