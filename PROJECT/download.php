<?php
if(isset($_GET['id'])) {
    $id = ($_GET['id']);

        if($id <= 0) {
        die('ID nije validan!');
    }
    else {
        $dbh = new mysqli('localhost', 'root', '','rt_4714_stefan_petrovic');
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }

        $sql = "SELECT * FROM docs WHERE id_doc = '$id'";
        $result = $dbh->query($sql);

        if($result) {
            if($result->num_rows == 1) {
                $row = mysqli_fetch_assoc($result);

                header("Content-Type: ". $row['tip_dokumenta']);
                header("Content-Length: ". $row['velicina_dokumenta']);
                header("Content-Disposition: attachment; filename=". $row['naziv_dokumenta']);

                echo $row['sadrzaj_dokumenta'];
            }
            else {
                echo 'Error! Nema dokumenta sa tim IDjem.';
            }
        }
        else {
            echo "Error! Query failed: <pre>{$dbh->error}</pre>";
        }
        @mysqli_close($dbh);
    }
}
else {
    echo 'Error! No ID was passed.';
}
?>