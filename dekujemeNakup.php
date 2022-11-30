<!DOCTYPE html>
<html>
<head>
    <title>Kino</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Děkujeme za nákup!</h1>
</header>


<main class="dekujemeMain">
    <div class="dekujemeContent">
    <h2>Vaše vstupenky</h2>
    <?php
    if (isset($_GET['poleSedadla']) && isset($_GET['kod'])) {
        $poleSedadla = json_decode($_GET['poleSedadla']);
        $kodVstupenky = $_GET['kod'];

        for ($i = 0; $i < count($poleSedadla); $i++) {
            echo "<p>";
            echo "Sedadlo ".   preg_replace('/[^0-9.]+/', '', $poleSedadla[$i]);
            echo "</p>";
        }
        echo "<p class='kodVstupenkyCont'> Kód vstupenky: <b class='kodVstupenky'>".$kodVstupenky."</b></p>";
        echo "Kód vstupenky si prosím uschovejte, bude vyžadován při vstupu.";
    }
    ?>
    <form method="post" action="index.php">
        <input class="vratitNaMainBtn" value="Zpět na hlavní stránku" type="submit">
    </form>
    </div>
</main>

</body>
</html>