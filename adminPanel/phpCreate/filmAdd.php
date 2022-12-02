<?php
//zkontroluje vstup
if (isset($_POST['novyFilm'])) {
    echo "START";
    $zapisReady = "true";
    if (empty($_POST['nazevFilmu'])) {
        $zapisReady = "false";
        echo "Neplatný název filmu!";
    }
    if (empty($_POST['je3dFilm'])) {
        $zapisReady = "false";
        echo "Neplatná vlastost'3D'!";
    }
    if (empty($_POST['zacatekFilmu'])) {
        $zapisReady = "false";
        echo "Neplatný začátek filmu!";
    }
    if (empty($_POST['konecFilmu'])) {
        $zapisReady = "false";
        echo "Neplatný konec filmu!";
    }

    //pokud jsou všechny pole platná
    if ($zapisReady == "true"){
        include "../../dbconnect.php";
        echo "VSE OK";
        $nazev = $_POST['nazevFilmu'];
        $je3d = $_POST['je3dFilm'];
        if ($je3d == "ano") {
            $je3d = 1;
        }else {
            $je3d = 0;
        }
        $zacatek = $_POST['zacatekFilmu'];
        $konec = $_POST['konecFilmu'];
        //zbaví stringu s datem písmena T
        $zacatek = str_replace("T"," ", $zacatek);
        $konec = str_replace("T"," ", $konec);
        //přidá na konec dat vteřiny
        $zacatek = $zacatek.":00";
        $konec = $konec.":00";
        echo "<br>Konec new: $konec <br>";

        //vloží nový řádek do tabulky rezervace a uloží jeho ID
        echo "Název: ".$nazev." 3D: ".$je3d." Začátek: ".$zacatek." Konec: ".$konec;
        $sqlRezervaceNew = "INSERT INTO rezervace () VALUES ()";
        $result = $conn->query($sqlRezervaceNew);
        $sqlRezervaceGetMaxId = "SELECT max(id_rezervace) FROM rezervace";
        $result = $conn->query($sqlRezervaceGetMaxId);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $maxIdRezervace = $row['max(id_rezervace)'];
            }
        }
        echo "MAX: ".$maxIdRezervace;

        //vloží nový film
        $sqlFilmAdd = "INSERT INTO program (id_rezervace, je_3d, nazev, zacatek, konec) 
            VALUES($maxIdRezervace,$je3d,'".$nazev."','".$zacatek."','".$konec."')";
        echo "$sqlFilmAdd";

        $result = $conn->query($sqlFilmAdd);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            }
        }

        header("Location: ../admin.php");
    } else {
        header("Location: ../admin.php");
    }
}
?>