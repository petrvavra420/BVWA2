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
    <h1>PROGRAM</h1>
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




<?php
echo "<main class='programMain'>";
include("dbconnect.php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id_filmu, id_rezervace, je_3d, nazev, zacatek, konec FROM program";
$result = $conn->query($sql);

$days = array('Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota');

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id_filmu"]. " idrez: " . $row["id_rezervace"]. " " . $row["nazev"]. $row["zacatek"]. $row["konec"]. "<br>";
        $casDny = date("w", strtotime($row["zacatek"]));
        $casHodiny = date("H", strtotime($row["zacatek"]));
        $casMinuty = date("i", strtotime($row["zacatek"]));

        echo "
        <div class='film'>
        <span class='filmOdkaz' id='film$row[id_rezervace]' >
            <div class='nazevFilmu'>$row[nazev]</div>
            <div class='zacatekFilmu'>$days[$casDny]</div>            
            <div class='zacatekFilmu'>$casHodiny:$casMinuty</div>            
        </span>
        <a class='koupitLink' href='rezervace.php?idRez=$row[id_rezervace]&idFilm=$row[id_filmu]'>
        Koupit
        </a>
        </div>";

    }
}

echo "</main>";
?>



<?php
/*for ($i = 0; $i < 300; $i++) {
    $randomcislo = rand(0, 1000);
    if ($randomcislo < 200) {
        echo "1";

    } else {
        echo "0";
    }
}
*/?>


</body>
</html>