<div class="mainContent">
    <form class="novyFilmForm" method="post" action="phpCreate/filmAdd.php">
        <label for="nazevFilmu">Název filmu: </label> <input class="novyFilmInput" id="nazevFilmu" name="nazevFilmu"
                                                             type="text"> <br>
        <label for="je3dFilm"> Je v 3D: </label> <span class="novyFilmInput"> Ano <input id="je3dFilm" name="je3dFilm"
                                                                                         value="ano"
                                                                                         type="radio"> Ne <input
                    id="je3dFilm" name="je3dFilm"
                    value="ne"
                    type="radio"></span>
        <br>
        <label for="zacatekFilmu">Začátek:</label> <input class="novyFilmInput" id="zacatekFilmu" name="zacatekFilmu"
                                                          type="datetime-local"> <br>
        <label for="konecFilmu">Konec:</label> <input class="novyFilmInput" id="konecFilmu" name="konecFilmu"
                                                      type="datetime-local"> <br>
         <label for="myfile">Obrázek:</label><input class="novyFilmInputFile" type="file" id="myfile"  name="filmObr"> <br>
        <input class="novyFilmSubmit" name="novyFilm" value="Přidat nový film" type="submit">
    </form>
</div>