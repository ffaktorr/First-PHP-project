<!doctype html>
<html lang="en">
<head>
    <?php
    require_once "class/Predmeti.php";
    require_once "class/Lab.php";
    require_once "class/Saradnik.php";
    require_once "class/Korisnik.php";
    require_once "class/Dokumenti.php";
    session_start();

if(isset($_GET['id'])){


    $id = $_GET['id'];
    $temp = Lab::ocitaj($id);
    $date = date_create($temp->datum);
    $saradnik = Saradnik::dohvati($temp->id_korisnika);
    $provera1=false;
    $provera2=false;
    $dokumenti=Dokumenti::izlistajZaVezbu($id);
    if (isset($_SESSION['ulogovan']) && $_SESSION['ulogovan'] == true) {
        $korisnik = unserialize($_SESSION['korisnik']);

        $provera1 = Saradnik::provera_saradnika_lab($korisnik->id_korisnika,$temp->id_vezbe);
        $provera2 = Saradnik::provera_saradnika_status($korisnik->id_korisnika);
    }

    ?>
    <meta charset="UTF-8">
    <title><?php echo $temp->naziv_vezbe; ?></title>
    <link rel="stylesheet" type="text/css" href="style/mystyle.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
<body>
<?php
echo "<a href='index.php'>Pocetna</a><br>";

?>

<h1 style='background-color: blanchedalmond; color: crimson'
    align='center'><?php echo $temp->naziv_vezbe . "<br>Datum: " . date_format($date, "d.m.Y H:i") . "<br>Laboratorija: " . $temp->lab; ?></h1>

<br>
<p align="center"><b>Saradnik koji radi na ovoj vezbi:</b></p>

<p style="font-size: larger" align="center"><?php if ($saradnik->status == 1){ ?><a
        href="profile.php?id=<?php echo $saradnik->id_korisnika ?>"> <?php echo $saradnik ?></a></p><?php } ?>
<div id="tabela_index">
    <table id="table" align="center" border="1">
        <tr>
            <td>
                <p align="center"><b>Opis vezbe:</b></p>
                <p align="center"><?php echo $temp->opis; ?> </p>
            </td>
        </tr>
        <tr>
            <td align="center">
              <b>Dokumenti za vezbu:</b><br>

                <?php
                if($dokumenti) {
                    foreach ($dokumenti as $d) {
                        ?><a  style="text-decoration: none;color: seagreen" href="download.php?id=<?php echo $d->id_doc ?>"><i
                            style="color:black;" class="fa fa-download"
                            aria-hidden="true"></i> <?php echo $d->naziv_dokumenta ?> </a>
                        <?php

                        if(isset($korisnik)){
                        if ($korisnik->id_korisnika == $saradnik->id_korisnika){

                            ?>
                            <input type="button" onclick="return confirm('Da li ste sigurni?'),location.href='obrisiDokument.php?id=<?php echo $d->id_doc ?>&id2=<?php echo $id; ?>'"; value="obrisi"/>

                            <?php

                        }


                        }


                        ?>

                        <br>
                        <?php

                    }
                }else{

                    echo "Nema dokumenata za ovu vezbu";
                }



                ?>
            </td>
        </tr>
    </table>

    <?php

    if($provera1 && $provera2) {
        ?>
        <div align="center">

            <a href="izmeniVezbu.php?id=<?php echo $id; ?>"
               onclick="return confirm('Da li ste sigurni da zelite da izmenite ovu vezbu?')">Izmeni</a>
            <a href="obrisiVezbu.php?id=<?php echo $id; ?>"
               onclick="return confirm('Da li ste sigurni da zelite da obrisete ovu vezbu?')">Obrisi</a>
<br><br>
            <form action="dodajDokument.php" method="post" enctype="multipart/form-data">
                <input type="file" id="file" name="uploaded_file" accept=".pdf,.zip,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.rar" required>
                <input type="submit" value="Upload">
                <input type='hidden' name='MAX_FILE_SIZE' value='1000000'/>
                <input hidden name="id_vezbe" value="<?php echo $id; ?>">
            </form>

        </div>
        <?php
        
    }elseif(($saradnik->staus == "0") && $provera2){
        ?>
        <div align="center">

            <a href="izmeniVezbu.php?id=<?php echo $id; ?>"
               onclick="return confirm('Da li ste sigurni da zelite da izmenite ovu vezbu?')">Izmeni</a>
            <a href="obrisiVezbu.php?id=<?php echo $id; ?>"
               onclick="return confirm('Da li ste sigurni da zelite da obrisete ovu vezbu?')">Obrisi</a>
        </div>




<?php
    }
    ?>
</div>


<?php
}else
    header("refresh:0;url=index.php");
?>




</body>
</html>

<script>

    var file = document.getElementById('file');

    file.onchange = function(e){
        var ext = this.value.match(/\.(.+)$/)[1];
        switch(ext)
        {
            case 'pdf':
            case 'zip':
            case 'doc':
            case 'docx':
            case 'ppt':
            case 'pptx':
            case 'xls':
            case 'rar':
            case 'xlsx':

                break;
            default:
                alert('Taj format nije dozvoljen');
                this.value='';
        }
    };


</script>
