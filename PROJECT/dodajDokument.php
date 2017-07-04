<?php
if(isset($_FILES['uploaded_file'])) {
    if($_FILES['uploaded_file']['error'] == 0) {
        $dbh = new mysqli("localhost", "root", "", "rt_4714_stefan_petrovic");


        $naziv_dokumenta = $dbh->real_escape_string($_FILES['uploaded_file']['name']);
        $tip_dokumenta = $dbh->real_escape_string($_FILES['uploaded_file']['type']);
        $sadrzaj_dokumenta = $dbh->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        $velicina_dokumenta = intval($_FILES['uploaded_file']['size']);
        $id_vezbe = $_POST['id_vezbe'];
        $timestamp = date('Y-m-d G:i:s');


        $sql2 = "INSERT INTO docs (id_doc, naziv_dokumenta, tip_dokumenta,velicina_dokumenta, sadrzaj_dokumenta, datum_up,id_vezbe) VALUES (NULL ,'$naziv_dokumenta', '$tip_dokumenta', '$velicina_dokumenta','$sadrzaj_dokumenta','$timestamp','$id_vezbe')";
        $sql1 = "SELECT * FROM docs WHERE naziv_dokumenta='$naziv_dokumenta'";
        $result1=$dbh->query($sql1);

        if (mysqli_num_rows($result1)==0) {
            $result2 = $dbh->query($sql2);
            if ($result2) {
                echo "<h1 style='margin-top: 200px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='#7fff00'>Uspesno ste dodali dokument</font></h1>";
                header("refresh:3;url=vezba.php?id=$id_vezbe");

            } else {
                echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>DOKUMENT JE PREVELIK!</font></h1>"
                    . "<pre>{$dbh->error}</pre>";
            }
        } else {
            echo "<h1 style='margin-top: 400px;background-color: black;margin-left: 500px;margin-right: 500px' align='center' ><font  color='red'>VEC POSTOJI TAJ DOKUMENT</font></h1>";
            header("refresh:2;url=vezba.php?id=$id_vezbe");
        }


    }
}

?>

