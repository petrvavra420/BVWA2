<!DOCTYPE html>
<html>
<head>
    <title>Platba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>POTVRZENÍ A PLATBA</h1>
</header>

<main>
    <div class="nakupContent">
        <div>
            <?php
            if (isset($_POST['pokracovatObjednavka'])) {
                $celkovaCena = 0;
                $array = json_decode($_GET['listky']);
                foreach ($array as $item) {
                    echo "<div class='nakupPolozka'>";
                    echo "Sedadlo č. ".preg_replace('/[^0-9.]+/', '', $item);
                    //projde všechny lístky, vytvoří souhrn a vypíše kategorii
                    if (isset($_POST[$item . "Select"])) {
                        $kategorieSedadla = $_POST[$item . "Select"];

                        switch ($kategorieSedadla) {
                            case "dite":
                                $celkovaCena += 29.90;
                                echo " - Dítě";
                                break;
                            case "dospely":
                                $celkovaCena += 149.90;
                                echo " - Dospělý";
                                break;
                            case "student":
                                $celkovaCena += 99.90;
                                echo " - Student";
                                break;
                            case "duchodce":
                                $celkovaCena += 99.90;
                                echo " - Důchodce";
                                break;
                        }
                    }
                    echo "</div>";
                }
                echo "<div class='dokonceniCelkovaCena'>Celková cena: " . $celkovaCena . " Kč</div>";
            }

            echo "
    <form method='post' action='aktualizaceDatabaze.php?listky=$_GET[listky]&idFilm=$_GET[idFilm]'>
        <input class='nakupPokracovat' name='koupit' value='Zaplatit' type='submit'>
    </form>
    ";
            ?>


        </div>
    </div>
</main>


</body>
</html>

