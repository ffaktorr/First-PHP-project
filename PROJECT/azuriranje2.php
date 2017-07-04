<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Azuriranje</title>
</head>
<body>

<?php

require_once "class/Korisnik.php";
require_once "class/Predmeti.php";
require_once "class/Saradnik.php";
require_once "class/Lab.php";
session_start();

$predmeti=Predmeti::dohvati();
$korisnici=Saradnik::izlistajSVE();
$temp="";


if (isset($_SESSION['ulogovan']) && $_SESSION['ulogovan']==true){

    $korisnik=unserialize($_SESSION['korisnik']);

    if($korisnik->tip == 'admin' || $korisnik->tip == 'saradnik'){
        

echo "<a href='index.php'>Pocetna</a><br>";
echo "Ulogovani ste kao : <a href='profile.php?id=$korisnik->id_korisnika'> ".$korisnik->ime." ".$korisnik->prezime."</a>";
echo "<br> <a href='logout.php'>Logout</a> ";
?>
<br>
<div style="margin-left: 300px; float: left ">
    <table border="1" id="table">
        <thead>
            <font style="font-size:     ">Predmeti <font>
        </thead>
        <tbody>
        <?php
        foreach ($predmeti as $p){
            echo "<tr><td width='70%'>";
            echo "<a href='predmet.php?id=$p->id_predmeta'>$p</a>";
           ?>
        </td><td width='15%'><a href="obrisiPredmet.php?id=<?php echo $p->id_predmeta?>" onclick="return confirm('Da li ste sigurni da zelite da obrisete predmet <?php echo $p ?>')">Obrisi</a> </td>
        <td width='15%'><a href="izmeniPredmet.php?id=<?php echo $p->id_predmeta?>" onclick="return confirm('Da li ste sigurni da zelite da izmenite predmet  <?php echo $p ?>') " >Izmeni</a></td>

        <?php } ?>

        </tbody>
    </table>
    <br>
    <form id="predmeti" action="dodajPredmet.php" method="post" title="Predmeti">
        <label style="font-size: larger">Dodaj novi predmet</label><br>
        <input type="text" name="naziv" placeholder="Naziv predmeta" size="37" required><br>
        <textarea name="opis" placeholder="Unesite opis predmeta..." cols="39" rows="5"></textarea><br>
        <input type="submit" value="OK" id="dodajPredmetDugme">
    </form>

</div>
    <div style="margin-right: 400px;float: right">
        <table border="1" id="table">
            <thead>
            <font style="font-size: larger"> Korisnici<font>
            </thead>
            <tbody>
            <?php
            foreach ($korisnici as $k){
                echo "<tr><td width='45%'>";
                echo "<a href='profile.php?id=$k->id_korisnika'>$k</a>";
                
                echo " (".$k->tip.") ";

                if ($k->status > 0){
                    echo "</td><td><font style='color: green'>Aktivan</font> <a href='promenaStatusa.php?id=$k->id_korisnika&s=1' onclick='return confirm()'> (promeni) </a></td> ";
                // <a href='promenaStatusa.php?id={$k->id_korisnika}&s='{$k->status}' ' > (promeni) </a>

                }else
                {
                    echo "</td><td><font style='color: red'>Neaktivan</font> <a href='promenaStatusa.php?id=$k->id_korisnika&s=0' onclick='return confirm()'> (promeni) </a></td> ";
                }

            ?>
                <td width='15%'><a href="obrisiKorisnika.php?id=<?php echo $k->id_korisnika?>" onclick="return confirm('Da li ste sigurni da zelite da obrisete korisnika <?php echo $k ?>')">Obrisi</a> </td>
                <td width='15%'><a href="izmeniKorisnika.php?id=<?php echo $k->id_korisnika?>" onclick="return confirm('Da li ste sigurni da zelite da izmenite korisnika  <?php echo $k ?>') " >Izmeni</a></td>


                <?php } ?>
            </tbody>
        </table>
        <br>
        <form id="predmeti" action="dodajKorisnika.php" method="post" title="Korisnici">
            <label style="font-size: larger">Dodaj novog korisnika</label><br>
            <input type="text" name="ime" placeholder="Ime" size="37" required><br>
            <input type="text" name="prezime" placeholder="Prezime" size="37" required><br>
            <input type="text" name="username" placeholder="Username" size="37" required><br>
            <input type="password" name="password" placeholder="Password" size="37" required><br>
            <input type="text" name="email" placeholder="Email" size="37" required><br>
            <select name="tip">
                <option selected disabled value="" >Izaberi tip</option>
                <option value="admin">Admin</option>
                <option value="saradnik">Saradnik</option>
                <option value="korisnik">Korisnik</option>
            </select><br>
            <input type="submit" onclick="return confirm('Da li ste sigurni da zelite da dodate korisnika?')" value="OK" id="dodajKorisnikaDugme">
        </form>
        <br>

        <form id="korisnici" action="dodajSaradnikaNaPredmet.php" method="post">
            <label style="font-size: ">Dodaj/Ukloni saradnika sa predmeta</label><br>
            <select name="predmet" required>
                <option value="" disabled selected>Izaberi predmet</option>
                <?php
                $predmeti=Predmeti::dohvati();
                foreach ($predmeti as $p) {
                    echo "<option value='$p->id_predmeta'>".$p."</option>";
                }
                ?>
            </select>
            <select name="saradnik" required>
                <option value="" disabled selected>Izaberi saradnika</option>
                <?php
                $saradnici=Saradnik::izlistaj();
                foreach ($saradnici as $s) {
                    if($s->status==1)
                    echo "<option value='$s->id_korisnika'>".$s."</option>";
                }
                ?>
            </select>
            <select name="opcija_saradnik" required>
                <option selected value="+">Dodaj</option>
                <option value="-">Ukloni</option>
            </select>
            <input onclick="return confirm('Da li ste sigurni?')" type="submit" value="OK">
        </form>





        <?php
    }else{
        echo "<h1 align='center'>Nemate pristup ovoj stranici</h1>";
        header("refresh:1;url=index.php");
    }
}else {
    echo "<h1 align='center'>Nemate pristup ovoj stranici</h1>";
    header("refresh:3;url=index.php");
}
?>

</body>
</html>

<script type="text/javascript" src="jquery/jquery-3.1.0.js"></script>
<script type="text/javascript" src="jquery/script.js"></script>