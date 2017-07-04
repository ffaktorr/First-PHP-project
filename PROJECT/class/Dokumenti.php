<?php
class Dokumenti
{
    private $id_doc;
    private $naziv_dokumenta;
    private $tip_dokumenta;
    private $velicina_dokumenta;
    private $sadrzaj_dokumenta;
    private $datum_up;
    private $id_vezbe;

    public function __construct($id_doc, $naziv_dokumenta, $tip_dokumenta, $velicina_dokumenta, $sadrzaj_dokumenta, $datum_up, $id_vezbe)
    {
        $this->id_doc = $id_doc;
        $this->naziv_dokumenta = $naziv_dokumenta;
        $this->tip_dokumenta = $tip_dokumenta;
        $this->velicina_dokumenta = $velicina_dokumenta;
        $this->sadrzaj_dokumenta = $sadrzaj_dokumenta;
        $this->datum_up = $datum_up;
        $this->id_vezbe = $id_vezbe;
    }

    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : "";
    }


    public static function izlistajZaVezbu($id_vezbe)
    {


        $dbh = new mysqli('localhost', 'root', '', 'rt_4714_stefan_petrovic');


        $sql = "SELECT * FROM docs WHERE id_vezbe='$id_vezbe'";
        $result = $dbh->query($sql);
        $niz = [];
        if ($result) {
            if ($result->num_rows == 0) {

            } else {
                foreach ($result as $row) {

                    array_push($niz, new Dokumenti($row['id_doc'], $row['naziv_dokumenta'], $row['tip_dokumenta'], $row['velicina_dokumenta'], $row['sadrzaj_dokumenta'], $row['datum_up'], $row['id_vezbe']));

                }
            }return $niz;

        }

    }

    public static function izlistajZaVezbu2($id_vezbe, $korisnik, $saradnik)
    {


        $dbh = new mysqli('localhost', 'root', '', 'rt_4714_stefan_petrovic');


        $sql = "SELECT * FROM docs WHERE id_vezbe='$id_vezbe'";
        $result = $dbh->query($sql);
        $niz = [];
        if ($result) {
            if ($result->num_rows == 0) {
                return false;
            } else {
                while ($row = $result->fetch_assoc()) {
                    if ($korisnik == $saradnik) {
                        ?>

                        <a href="download.php?id=<?php echo $row['id_doc'] ?>"><?php echo $row['naziv_dokumenta'] ?></a>
                        <input type="button"
                               onclick="return confirm('Da li ste sigurni?'),location.href='obrisiDokument.php?id=<?php echo $row['id_doc'] ?>&id2=<?php echo $id_vezbe; ?>';"
                               value="obrisi"/>
                        <br>
                        <?php
                    } else { ?>
                        <a href="download.php?id=<?php echo $row['id_doc'] ?>"><?php echo $row['naziv_dokumenta'] ?></a>
                        <br>
                    <?php }

                }

            }

        }
    }
}
