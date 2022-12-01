
<?php
$input = filter_input_array(INPUT_POST);
include "../../dbconnect.php";

//zajišťuje aktualizaci do databáze

$sqlEdit = "UPDATE program SET id_rezervace ='".$input['id_rezervace']."', je_3d = '".$input['je_3d']."',
 nazev ='".$input['nazev']."', zacatek = '".$input['zacatek']."', konec = '".$input['konec']."' WHERE id_filmu = '".$input['id_filmu']."'";
$sqlDelete = "DELETE from program WHERE id_filmu='".$input['id_filmu']."'";

if ($input['action'] == 'edit') {
    echo "edit";
    $conn->query($sqlEdit);
} else if ($input['action'] == 'delete') {
    echo "delete";
    $conn->query($sqlDelete);
}
?>


