
<?php
$input = filter_input_array(INPUT_POST);
include "../../dbconnect.php";

//zajišťuje aktualizaci do databáze

$sqlEdit = "UPDATE vstupenky SET id_vstupenky ='".$input['id_vstupenky']."', id_filmu = '".$input['id_filmu']."',
 id_rezervace ='".$input['id_rezervace']."', cisloSedadla = '".$input['cisloSedadla']."', vstupniKod = '".$input['vstupniKod']."' WHERE id = '".$input['id']."'";
$sqlDelete = "DELETE from vstupenky WHERE id='".$input['id']."'";

//načte ID rezervace a cislo sedadla (při mazání js skript posílá pouze ID)
$sqlRezervace = "SELECT id_rezervace,cisloSedadla FROM vstupenky where id = '".$input['id']."'";
$result = $conn->query($sqlRezervace);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rezervaceId = $row['id_rezervace'];
        $cisloSedadla = $row['cisloSedadla'];
    }
}


//načte rezervace string podle ID rezervace z předchozí querry
$sqlGetRezStr = "SELECT rezervace_string FROM rezervace where id_rezervace = '".$rezervaceId."'";

$result = $conn->query($sqlGetRezStr);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rezervaceString = $row['rezervace_string'];
        echo $rezervaceString;
    }
}

//aktualizuje string(uvolní místo po smazání vstupenky)
$rezervaceStringUpd = substr_replace($rezervaceString, "0", $cisloSedadla - 1, 1);
$sqlUpdateString = "UPDATE rezervace SET rezervace_string = '".$rezervaceStringUpd."' WHERE id_rezervace = '".$rezervaceId."'";

//odešle dotazy
if ($input['action'] == 'edit') {
    echo "edit";
    $conn->query($sqlEdit);
} else if ($input['action'] == 'delete') {
    echo "delete";
    $conn->query($sqlDelete);
    $conn->query($sqlUpdateString);
}
?>

