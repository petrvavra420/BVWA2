<head>
    <link rel="stylesheet" href="adminStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<?php
include "../dbconnect.php";
session_start();
$_SESSION['vybranyFilm'] = "";
if (isset($_POST['filmVyber'])) {
    if (!empty($_POST['idFilm'])) {
        //uchovává vybraný film
        $_SESSION['vybranyFilm'] = $_POST['idFilm'];

    }

    //najde ID rezervace které náleží filmu
    $sql = "SELECT id_rezervace FROM program WHERE id_filmu = " . $_SESSION['vybranyFilm'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $idRezervace = $row['id_rezervace'];
            $_SESSION['idRez'] = $idRezervace;
        }
    }
}
?>
<header>
    <h1>Vytvoření nové vstupenky</h1>
</header>
<div class="vstupenkaNewNav">
    <!--Formulář který vypíše všechny filmy ze kterých si admin může vybrat-->

    <div class="mainContentVstupenkaNew">
        <a class="vstupNavBtns" href="admin.php">Zpět</a>
        <button class="vstupNavBtns"
                onclick="NakoupitListky(<?php echo $_SESSION['vybranyFilm'] . "," . $_SESSION['idRez']; ?>)">Vytvořit
            vstupenky
        </button>
        <form class="novaVstupenkaForm" method="post" action="">
            <select name="idFilm" class="vstupNavSelect">
                <?php

                $casAktualni = date("Y-m-d H:i:00");
                $pocitadloFilmu = 0;
                $maxFilmu = 15;
                $sql = "SELECT id_filmu,id_rezervace,nazev,zacatek FROM program ORDER BY zacatek ASC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($casAktualni < $row["zacatek"] && $pocitadloFilmu < $maxFilmu) {
                            //vypsat do formu všechny filmy
                            if ($row['id_filmu'] == $_SESSION['vybranyFilm']) {
                                echo "<option value='$row[id_filmu]' selected>$row[nazev]</option>";
                            } else {
                                echo "<option value='$row[id_filmu]'>$row[nazev]</option>";
                            }
                            $pocitadloFilmu++;
                        }
                    }
                }
                ?>

            </select>


            <input class="vstupNavSubmit" name="filmVyber" value="Vybrat film" type="submit">
        </form>

    </div>
</div>

<main class="mainContent">
    <div>
        <?php
        //pokud admin vybere film vypíšou se jeho rezervace
        if (!empty($_SESSION['vybranyFilm'])) {


            $sql = "SELECT id_rezervace, rezervace_string FROM rezervace WHERE id_rezervace = " . $idRezervace;
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
                                echo "<a id='sedadlo$cisloSedadla' class='rezervaceVolno' onclick='RezervaceClick(this,$_SESSION[vybranyFilm]);'>";
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
        }

        ?>
    </div>
</main>

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

    function NakoupitListky(idFilm, idRez) {
        pokracujeNakup = true;
        console.log("------------");
        console.log(idFilm);

        poleVybraneSedadla.forEach(function (number) {
            console.log("POLE: " + number);
        });
        if (poleVybraneSedadla.length > 0) {
            let jsonListky = JSON.stringify(poleVybraneSedadla);
            /*let stringDataUrl = "nakupListku.php?listky=" + jsonListky;
            stringDataUrl = stringDataUrl + "&idFilm=" + idFilm;
            window.location = stringDataUrl;*/
            var url = 'phpCreate/vstupenkaAdd.php';
            var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="idFilm" value="' + idFilm + '" />' +
                '<input type="text" name="idRez" value="' + idRez + '" />' +
                '<input type="text" name="poleSedadla" value=' + jsonListky + ' />' +
                '</form>');
            $('body').append(form);
            form.submit();

            /*$.ajax({
                type: "POST",
                url: "phpCreate/vstupenkaAdd.php",
                data: {poleSedadla: jsonListky, idFilm: idFilm, idRez: idRez},
                success: function (res) {
                    let stringUrl = "phpCreate/vstupenkaAdd.php";
                    window.location = stringUrl;
                }
            });*/


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


