$(document).ready(function(){
    $('#programyTable').Tabledit({
        restoreButton: false,
        columns: {
            identifier: [0, 'id_filmu'],
            editable: [[1, 'id_rezervace'], [2, 'je_3d'], [3, 'nazev'], [4, 'zacatek'], [5, 'konec']]
        },
        hideIdentifier: true,
        url: 'phpEdit/programyEdit.php'
    });
});