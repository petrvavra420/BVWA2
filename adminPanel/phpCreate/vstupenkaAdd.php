<?php
if (!empty($_POST['poleSedadla']) && !empty($_POST['idFilm']) && !empty($_POST['idRez'])) {
    $array = json_decode($_POST['poleSedadla']);
    $idFilm = $_POST['idFilm'];
    $idRez = $_POST['idRez'];

    include_once("../dbconnect.php");

    /*$arrayVstupniKody = [];
    $sql = "SELECT id_rezervace FROM program WHERE id_filmu = " . $_GET['idFilm'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $idRezervace = $row['id_rezervace'];
        }
    }*/

    $sql = "SELECT rezervace_string FROM rezervace WHERE id_rezervace = $idRez";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $rezervaceStringUpdated = $row['rezervace_string'];
    $vstupniKod = substr(md5(uniqid(mt_rand(), true)), 0, 8);

    //vybere největší ID vstupenky ze vstupenek a přičte k němu 1 => nové ID pro nový insert
    $sqlId = "SELECT max(id_vstupenky) FROM vstupenky";
    $resultId = $conn->query($sqlId);
    if ($resultId->num_rows > 0) {
        while ($rowId = $resultId->fetch_assoc()) {
            $idVstupenky = $rowId['max(id_vstupenky)'] + 1;

        }
    }

    //projde všechny vybrané sedadla a aktualizuje string
    foreach ($array as $item) {
        $cisloSedadla = preg_replace('/[^0-9.]+/', '', $item);
        $rezervaceStringUpdated = substr_replace($rezervaceStringUpdated, "1", $cisloSedadla - 1, 1);

        //toto spustit nakonec
        $sql = "INSERT INTO vstupenky (id_vstupenky,id_filmu,id_rezervace,cisloSedadla,vstupniKod) VALUES ($idVstupenky,$idFilm,$idRez,$cisloSedadla,'$vstupniKod')";
        $result = $conn->query($sql);
    }

    //odešle aktualizovaný string do DB
    $sql = "UPDATE rezervace SET rezervace_string = '$rezervaceStringUpdated' WHERE id_rezervace = $idRez";
    $result = $conn->query($sql);

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>KinoAdmin</title>
    <link rel="stylesheet" href="../adminStyle.css">

</head>
<body>

<header>
    <h1>Vstupenka vytvořena</h1>
</header>


<main class="mainContent">
    <div class="vstupenkaVytvorenaContent">
        <?php
        for ($i = 0; $i < count($array); $i++) {
            echo "<p class='vstupenkaSedadlo'>";
            echo "Sedadlo " . preg_replace('/[^0-9.]+/', '', $array[$i]);
            echo "</p>";
        }
        ?>
        <br>
        <p>Vstupní kód: <b class="vstupniKod"> <?php echo $vstupniKod ?> </b></p>
        <a class="vstupenkaZpet" href="../novaVstupenka.php">Zpět</a>
    </div>

</main>

</body>
</html>
