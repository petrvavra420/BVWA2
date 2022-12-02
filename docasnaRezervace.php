<?php
if (isset($_POST['poleSedadla'])) {

    if (isset($_POST["rezervaceTyp"])) {


        //dekóduje sedadla do pole a načte idRezervace z databáze podle id filmu z POST requestu
        $idFilm = $_POST['idFilm'];
        echo "ID FILM: " . $idFilm;
        include_once("dbconnect.php");
        $array = json_decode($_POST['poleSedadla']);

        $arrayVstupniKody = [];
        $sql = "SELECT id_rezervace FROM program WHERE id_filmu = " . $idFilm;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $idRezervace = $row['id_rezervace'];
            }
        }

        echo "ID REZ: " . $idRezervace;

        //vrátí rezervace string
        $sql = "SELECT rezervace_string FROM rezervace WHERE id_rezervace = $idRezervace";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $rezervaceStringUpdated = $row['rezervace_string'];

        //aktualizuje string na zabrané sedadla
        foreach ($array as $item) {
            $cisloSedadla = preg_replace('/[^0-9.]+/', '', $item);

            $rezervaceTyp = $_POST['rezervaceTyp'];
            echo ";;RezervaceTyp: ".$rezervaceTyp." ;;;";
            if ($rezervaceTyp == "rezervuj") {
                echo "REEEEEEZ";
                $rezervaceStringUpdated = substr_replace($rezervaceStringUpdated, "1", $cisloSedadla - 1, 1);
            } else if ($rezervaceTyp == "odrezervuj") {
                echo "ODREZERVOVAAAAAAAAAAAAAAAAAAAAAAAANO";
                $rezervaceStringUpdated = substr_replace($rezervaceStringUpdated, "0", $cisloSedadla - 1, 1);
            }

        }

        //odešle aktualizovaný string do DB
        $sql = "UPDATE rezervace SET rezervace_string = '$rezervaceStringUpdated' WHERE id_rezervace = $idRezervace";
        echo "<br>" . $sql;
        $result = $conn->query($sql);
    }
}
?>