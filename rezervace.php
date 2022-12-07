<!DOCTYPE html>
<html>
<head>
    <title>Kino</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>

<header>
    <h1>Rezervace vstupenky</h1>
</header>

<nav class="navigace">

    <button class="rezervaceNavBtns" onclick="Zpet()">Zpět na program</button>
    <button class="rezervaceNavBtns" onclick="NakoupitListky(<?php echo $_GET["idFilm"] ?>)">Pokračovat k platbě
    </button>

</nav>

<main>

    <?php
    include_once("dbconnect.php");
    $sql = "SELECT id_rezervace, rezervace_string FROM rezervace WHERE id_rezervace = " . $_GET['idRez'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rezervaceString = $row['rezervace_string'];
            echo "<table>";
            for ($i = 0; $i < 15; $i++) {
                echo "<tr>";
                for ($j = 0; $j < 20; $j++) {
                    if ($j == 10) {
                        echo "<td>";
                        echo "<span class='ulicka'>";
                        echo "&nbsp";
                        echo "</span>";
                        echo "</td>";
                    }
                    if (substr($rezervaceString, $j + ($i * 20), 1) == "1") {
                        echo "<td>";
                        echo "<span class='rezervaceZabrano'>";
                        echo ($j + ($i * 20)) + 1;
                        echo "</span>";
                        echo "</td>";
                    } else {
                        $cisloSedadla = ($j + ($i * 20) + 1);
                        echo "<td>";
                        echo "<a id='sedadlo$cisloSedadla' class='rezervaceVolno' onclick='RezervaceClick(this,$_GET[idFilm]);'>";
                        echo ($j + ($i * 20)) + 1;
                        echo "</a>";
                        echo "</td>";
                    }

                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</main>

</body>
<script>
    let poleVybraneSedadla = [];
    window.addEventListener("pagehide", priOdchoduZrusRezervace);
    //tyto dvě proměnné jsou kvůli odchodu uživatele který má vybrané vstupenky
    //rezervaceClick volá funkci docasneRezervuj která buď zarezervuje nebo zruší rezervaci
    let idFilmuPriOdchodu;
    let pokracujeNakup = false;

    function RezervaceClick(obj, idFilm) {
        //pokud je rezervace už zabraná uživatelem
        if (obj.style.backgroundColor == "rgb(196, 175, 24)") {
            obj.style.background = "green";
            const indexVybranaPolozka = poleVybraneSedadla.indexOf(obj.id);
            docasneRezervuj(idFilm, "odrezervuj");
            idFilmuPriOdchodu = idFilm;
            poleVybraneSedadla.splice(indexVybranaPolozka, 1);
        } else {
            //pokud není, zaber ji
            idFilmuPriOdchodu = idFilm;
            obj.style.background = "#C4AF18";
            poleVybraneSedadla.push(obj.id);
            docasneRezervuj(idFilm, "rezervuj");
        }

    }

    function Zpet() {
        let stringDataUrl = "program.php";
        window.location = stringDataUrl;
    }

    function NakoupitListky(idFilm) {
        pokracujeNakup = true;
        console.log("------------");
        console.log(idFilm);

        poleVybraneSedadla.forEach(function (number) {
            console.log("POLE: " + number);
        });
        if(poleVybraneSedadla.length > 0) {
            let jsonListky = JSON.stringify(poleVybraneSedadla);
            let stringDataUrl = "nakupListku.php?listky=" + jsonListky;
            stringDataUrl = stringDataUrl + "&idFilm=" + idFilm;
            window.location = stringDataUrl;
        } else {
            alert("Nejsou vybrané žádné místa.");
        }
    }

    //pošle post request na docasnaRezervace.php který zajistí rezervaci/zrušení vybraných míst
    //(kvůli více uživatelům kteří si budou objednávat naráz)
    function docasneRezervuj(idFilm, rezervaceTyp) {
        console.log(idFilm);
        let jsonListky = JSON.stringify(poleVybraneSedadla);

        $.ajax({
            type: "POST",
            url: "docasnaRezervace.php",
            data: {poleSedadla: jsonListky, idFilm: idFilm, rezervaceTyp: rezervaceTyp},
            success: function (res) {

            }
        });
    }

    function priOdchoduZrusRezervace() {
        //pokud uživatel klikne na pokračovat v nákupu, rezervace se nezruší
        if (!pokracujeNakup) {
            docasneRezervuj(idFilmuPriOdchodu, "odrezervuj");
        }
    }

    /*
    window.addEventListener("beforeunload", function(event) {
        console.log("UNLOAD:1");
        docasneRezervuj(idFilm, "odrezervuj");
        //event.preventDefault();
        //event.returnValue = null; //"Any text"; //true; //false;
        //return null; //"Any text"; //true; //false;
    });

     */

<?php
mysqli_close($conn);
?>
</script>
</html>


