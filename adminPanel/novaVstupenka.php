<?php
echo "vstupenka new";
include "../../dbconnect.php";
$sql = "SELECT id_filmu,id_rezervace,nazev FROM program";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //vypsat do formu všechny filmy
    }
}
?>

<div class="mainContent">
    <form class="novyFilmForm" method="post" action="phpCreate/filmAdd.php" enctype="multipart/form-data">
        <label for="nazevFilmu">Film: </label> <input class="novyFilmInput" id="nazevFilmu" name="nazevFilmu"
                                                             type="text"> <br>

        <label for="zacatekFilmu">Začátek:</label> <input class="novyFilmInput" id="zacatekFilmu" name="zacatekFilmu"
                                                          type="datetime-local"> <br>
        <label for="konecFilmu">Konec:</label> <input class="novyFilmInput" id="konecFilmu" name="konecFilmu"
                                                      type="datetime-local"> <br>
        <label for="myfile">Obrázek:</label><input class="novyFilmInputFile" type="file" id="myfile"  name="filmObr"> <br>
        <input class="novyFilmSubmit" name="novyFilm" value="Přidat nový film" type="submit">
    </form>
</div>


