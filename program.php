<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kinoprogram</title>
    <link rel="stylesheet" href="style.css">


</head>
<body>

<header>
    <a class="programH1" href="index.php"><h1>PROGRAM</h1></a>
</header>

<nav class="navigace">

    <a href="">
        Program
    </a>

    <a href="">
        Pronájem
    </a>

    <a href="">
        Kontakt
    </a>

</nav>


<div class="centerContent">
    <?php
    echo "<main class='programMain'>";
    include("dbconnect.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id_filmu, id_rezervace, je_3d, nazev, zacatek, konec, obrazek FROM program ORDER BY zacatek ASC";
    $result = $conn->query($sql);

    $days = array('Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota');


    $casAktualni = date("Y-m-d H:i:00");
    $casAktualniRokDenMesic = date("Y-m-d");

    $pocitadloFilmu = 0;
    $maxFilmu = 30;
    //vypíše filmy z databáze
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //vypíše pouze maximum filmů podle proměnných výše
            if ($casAktualni < $row["zacatek"] && $pocitadloFilmu < $maxFilmu) {
                $casDenMesic = date("d. m. ", strtotime($row['zacatek']));
                $casDny = date("w", strtotime($row["zacatek"]));
                $casHodiny = date("H", strtotime($row["zacatek"]));
                $casMinuty = date("i", strtotime($row["zacatek"]));

                $casRokDenMesic = date("Y-m-d", strtotime($row['zacatek']));
                $casFilmu = $casHodiny . ":" . $casMinuty;
                if ($casRokDenMesic == $casAktualniRokDenMesic) {
                    $dnes = "Dnes v";
                } else {
                    $dnes = "";
                }

                if ($row['je_3d'] == 1) {
                    $je3d = "3D";
                } else {
                    $je3d = "2D";
                }

                echo "
        <div class='film' onmouseover='changeBackground($row[obrazek])'>
        <span class='filmOdkaz' id='film$row[id_rezervace]' >
            <div class='nazevFilmu'>$row[nazev]</div>
            <div class='zacatekFilmu'>$dnes $days[$casDny]</div>            
            <div class='je3dFilm'>$je3d</div>            
            <div class='zacatekFilmu'>$casDenMesic $casHodiny:$casMinuty</div>            
        </span>
        <a class='koupitLink' href='rezervace.php?idRez=$row[id_rezervace]&idFilm=$row[id_filmu]'>
        Koupit
        </a>
        </div>";
                $pocitadloFilmu++;
            }
        }
    }

    echo "</main>";
    ?>
</div>


<?php
/*for ($i = 0; $i < 300; $i++) {
    $randomcislo = rand(0, 1000);
    if ($randomcislo < 200) {
        echo "1";

    } else {
        echo "0";
    }
}
*/
mysqli_close($conn); ?>

<script>
    function changeBackground(imgSource) {
        console.log("HOVER OK" + imgSource);
    }

</script>
</body>
</html>