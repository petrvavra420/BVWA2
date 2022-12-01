<?php
if (!empty($_POST['koupit'])) {
    include_once("dbconnect.php");
    $array = json_decode($_GET['listky']);

    $arrayVstupniKody = [];
    $sql = "SELECT id_rezervace FROM program WHERE id_filmu = " . $_GET['idFilm'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $idRezervace = $row['id_rezervace'];
        }
    }

    $sql = "SELECT rezervace_string FROM rezervace WHERE id_rezervace = $idRezervace";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $rezervaceStringUpdated = $row['rezervace_string'];
    echo $rezervaceStringUpdated;
    $vstupniKod = substr(md5(uniqid(mt_rand(), true)), 0, 8);

    //vybere největší ID vstupenky ze vstupenek a přičte k němu 1 => nové ID pro nový insert
    $sqlId = "SELECT max(id_vstupenky) FROM vstupenky";
    $resultId = $conn->query($sqlId);
    if ($resultId->num_rows > 0) {
        while ($rowId = $resultId->fetch_assoc()) {
            $idVstupenky= $rowId['max(id_vstupenky)'] + 1;

        }
    }
    echo "ID VSTUPENKY: " . $idVstupenky;


    //projde všechny vybrané sedadla a aktualizuje string
    foreach ($array as $item) {
        $cisloSedadla = preg_replace('/[^0-9.]+/', '', $item);
        $rezervaceStringUpdated = substr_replace($rezervaceStringUpdated, "1", $cisloSedadla - 1, 1);

        //toto spustit nakonec
        array_push($arrayVstupniKody, $vstupniKod);
        $sql = "INSERT INTO vstupenky (id_vstupenky,id_filmu,id_rezervace,cisloSedadla,vstupniKod) VALUES ($idVstupenky,$_GET[idFilm],$idRezervace,$cisloSedadla,'$vstupniKod')";
        echo $sql;
        $result = $conn->query($sql);
    }
    //odešle aktualizovaný string do DB
    echo "<br>" . $rezervaceStringUpdated;
    $sql = "UPDATE rezervace SET rezervace_string = '$rezervaceStringUpdated' WHERE id_rezervace = $idRezervace";
    echo "<br>" . $sql;
    $result = $conn->query($sql);

}
?>


<?php
$poleSedadla = json_encode($array);

/*foreach ($array as $item){
    echo "<p>";
    echo "Sedadlo ".preg_replace('/[^0-9.]+/', '', $item);
    echo "</p>";
}*/
for ($i = 0; $i < count($array); $i++) {
    echo "<p>";
    echo "Sedadlo " . preg_replace('/[^0-9.]+/', '', $array[$i]);
    echo " Kód vstupenky: " . $arrayVstupniKody[$i];
    echo "</p>";
}
header('Location: dekujemeNakup.php?poleSedadla=' . $poleSedadla . '&kod=' . $vstupniKod);
?>


