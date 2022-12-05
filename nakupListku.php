<!DOCTYPE html>
<html>
<head>
    <title>Souhrn objednávky</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>SOUHRN OBJEDNÁVKY</h1>
</header>

<main>
    <div class="nakupContent">
        <div>
            <h3>Vybrané sedadla</h3>
            <?php
            if (isset($_GET["listky"])) {
                echo "<form method='post' action='dokonceniObjednavky.php?listky=$_GET[listky]&idFilm=$_GET[idFilm]'>";
                $array = json_decode($_GET['listky']);
                if (count($array) <= 0){
                    header("Location: index.php ");
                }
                foreach ($array as $item) {
                    echo "<div class='nakupPolozka'>";
                    echo "Sedadlo č. " . preg_replace('/[^0-9.]+/', '', $item);
                    $selectName = $item . "Select";
                    echo "
            <select name='$selectName'>
            <option value='dite'>Dítě do 15 let</option>
            <option value='student'>Student</option>
            <option value='dospely'>Dospělý</option>
            <option value='duchodce'>Důchodce</option>
            </select>";
                    echo "</div>";
                }
                echo "<input class='nakupPokracovat' name='pokracovatObjednavka' value='Pokračovat' type='submit'>";
                echo "</form>";
            }

            ?>
        </div>
    </div>
</main>


</body>
</html>


