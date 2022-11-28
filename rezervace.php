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
    <button onclick="NakoupitListky(<?php echo $_GET["idFilm"] ?>)">Pokračovat k platbě</button>
    <?php
    include_once("dbconnect.php");
    $sql = "SELECT id_rezervace, rezervace_string FROM rezervace WHERE id_rezervace = ".$_GET['idRez'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rezervaceString = $row['rezervace_string'];
            echo "<table>";
            for ($i = 0; $i < 15;$i++){
                echo "<tr>";
                for ($j = 0; $j < 20;$j++){

                    if (substr($rezervaceString,$j + ($i * 20),1) == "1"){
                        echo "<td>";
                        echo "<span class='rezervaceZabrano'>";
                        echo ($j + ($i * 20)) + 1;
                        echo "</span>";
                        echo "</td>";
                    }else {
                        $cisloSedadla =( $j + ($i * 20)+1);
                        echo "<td>";
                        echo "<a id='sedadlo$cisloSedadla' class='rezervaceVolno' onclick='RezervaceClick(this);'>";
                        echo ($j + ($i * 20)) + 1;
                        echo "</a>";
                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
            echo $_GET['idFilm'];
        }
    }
    ?>
</main>

</body>
<script>
    let poleVybraneSedadla = [];
    function RezervaceClick(obj) {
        //pokud je rezervace už zabraná uživatelem
        if (obj.style.backgroundColor == "rgb(196, 175, 24)") {
            obj.style.background = "green";
            const indexVybranaPolozka = poleVybraneSedadla.indexOf(obj.id);
            poleVybraneSedadla.splice(indexVybranaPolozka,1);
        }else {
            //pokud není, zaber ji
            obj.style.background = "#C4AF18";
            poleVybraneSedadla.push(obj.id);
        }
    }
    function NakoupitListky(idFilm) {
        console.log("------------");
        console.log(idFilm);

        poleVybraneSedadla.forEach(function(number) {
            console.log("POLE: " + number);
        });
        let jsonListky = JSON.stringify(poleVybraneSedadla);
        let stringDataUrl = "nakupListku.php?listky=" + jsonListky;
        stringDataUrl = stringDataUrl+ "&idFilm=" + idFilm;
        window.location = stringDataUrl;
        /*
        $.ajax({
            type : "POST",  //type of method
            url  : "nakupListku.php",  //your page
            data : { poleSedadla : jsonListky},// passing the values
            success: function(res){
                window.location = stringDataUrl;
                //do what you want here...
            }
        });
        */

    }

</script>
</html>


