

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
    <?php
    if (isset($_POST['pokracovatObjednavka'])) {
        $celkovaCena = 0;
        $array = json_decode($_GET['listky']);
        foreach ($array as $item){
            echo $item;
            //projde všechny lístky, vytvoří souhrn a vypíše kategorii
            if (isset($_POST[$item."Select"])){
                $kategorieSedadla =  $_POST[$item."Select"];
                echo $kategorieSedadla;
                switch ($kategorieSedadla){
                    case "dite":
                        $celkovaCena += 29.90;
                        break;
                    case "dospely":
                        $celkovaCena += 149.90;
                        break;
                    case "student":
                        $celkovaCena += 99.90;
                        break;
                    case "duchodce":
                        $celkovaCena += 99.90;
                        break;
                }
            }
            echo "<br>";
        }
        echo "Celková cena: ".$celkovaCena;
    }
    echo "
    <form method='post' action='aktualizaceDatabaze.php?listky=$_GET[listky]&idFilm=$_GET[idFilm]'>
        <input name='koupit' value='Koupit' type='submit'>
    </form>
    ";
    ?>


</main>


</body>
</html>

