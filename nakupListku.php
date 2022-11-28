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
<h1>Vybrané sedadla:</h1>
    <?php
    if (isset($_GET["listky"])){
        echo "<form method='post' action='dokonceniObjednavky.php?listky=$_GET[listky]&idFilm=$_GET[idFilm]'>";
        $array = json_decode($_GET['listky']);
        foreach ($array as $item){
            echo $item;
            $selectName = $item."Select";
            echo "
            <select name='$selectName'>
            <option value='dite'>Dítě do 15 let</option>
            <option value='student'>Student</option>
            <option value='dospely'>Dospělý</option>
            <option value='duchodce'>Důchodce</option>
            </select>";
            echo "<br>";
        }
        echo "<input name='pokracovatObjednavka' value='Pokračovat' type='submit'>";
        echo "</form>";
    }
    ?>

</main>


</body>
</html>


