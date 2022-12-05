<!DOCTYPE html>
<html>
<head>
    <title>Kino</title>
    <link rel="stylesheet" href="style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body id="bodyIndex">
<img id="imgBack" src="">

<header>
    <h1>KINO</h1>
</header>

<nav class="navigace">
    <a href="program.php">
        Program
    </a>


    <a href="">
        Pronájem
    </a>

    <a href="">
        Kontakt
    </a>

</nav>


<main>
    <?php


    echo "<main class='programMain'>";
    include("dbconnect.php");

    $sql = "SELECT id_filmu, id_rezervace, je_3d, nazev, zacatek, konec, obrazek FROM program ORDER BY zacatek ASC";
    $result = $conn->query($sql);

    $days = array('Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota');


    $casAktualni = date("Y-m-d H:i:00");
    $casAktualniRokDenMesic = date("Y-m-d");

    $pocitadloFilmu = 0;
    $maxFilmu = 3;
    //vypíše filmy z databáze
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //vypíše pouze maximum filmů podle proměnných výše
            if ($casAktualni < $row["zacatek"] && $pocitadloFilmu < $maxFilmu) {
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

                $obr = '"'.$row['obrazek'].'"';
                echo "
        <div class='film' onmouseover='changeBackground($obr)' onmouseout='revertBackground()'>
        <span class='filmOdkaz' id='film$row[id_rezervace]' >
            <div class='nazevFilmu'>$row[nazev]</div>
            <div class='zacatekFilmu'>$dnes $days[$casDny]</div>            
            <div class='je3dFilm'>$je3d</div>            
            <div class='zacatekFilmu'>$casFilmu</div>            
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
    mysqli_close($conn);
    ?>


    <script>
        document.getElementById("imgBack").style.opacity = "0.0";
        function changeBackground(imgSource) {
                stringSource = "img/" + imgSource;
                console.log(stringSource);
                document.getElementById("imgBack").src = stringSource;
                document.getElementById("imgBack").style.opacity = "0.2";
                document.getElementById("imgBack").style.transitionDuration = "0.4s";
                document.getElementById("imgBack").style.visibility = "visible";
        }
        function revertBackground(){
            document.getElementById("imgBack").style.opacity = "0";
            document.getElementById("imgBack").style.visibility = "hidden";

        }

    </script>
</main>

</body>
</html>