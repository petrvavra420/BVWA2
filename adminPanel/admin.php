


<!DOCTYPE html>
<html>
<head>
    <title>KinoAdmin</title>
    <link rel="stylesheet" href="adminStyle.css">
</head>
<body>

<header>
    <h1>Admin panel</h1>
</header>

<div class="navFlex">
    <nav class="navigace">


            <button>Programy</button>
            <button>Rezervace</button>
            <button>Vstupenky</button>


        <!--<a href="">
            Rezervace
        </a>

        <a href="">
            Vstupenky
        </a>-->

    </nav>
</div>

<main>

</main>
<?php
session_start();
if (isset($_SESSION['uzivatel'])) {
    if ($_SESSION['uzivatel'] == "admin") {
    } else {
        header("Location: index.php");
    }
}
?>
</body>
</html>

