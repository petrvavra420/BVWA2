$(document).ready(function(){
    $('#vstupenkyTable').Tabledit({
        restoreButton: false,
        columns: {
            identifier: [0, 'id'],
            editable: [[1, 'id_vstupenky'], [2, 'id_filmu'], [3, 'id_rezervace'], [4, 'cisloSedadla'], [5, 'vstupniKod']]
        },
        hideIdentifier: true,
        url: 'phpEdit/vstupenkyEdit.php'
    });
});