<?php
session_start();
if (isset($_SESSION['uzivatel'])) {
    if ($_SESSION['uzivatel'] == "admin") {
        if (isset($_POST['programySubmit'])) {
            $_SESSION['currentPage'] = "programy";
        } else if (isset($_POST['rezervaceSubmit'])) {
            $_SESSION['currentPage'] = "rezervace";
        } else if (isset($_POST['vstupenkySubmit'])) {
            $_SESSION['currentPage'] = "vstupenky";
        } else if (isset($_POST['novyFilmSubmit'])) {
            $_SESSION['currentPage'] = "novyFilm";
        } else if (isset($_POST['novaVstupenkaSubmit'])) {
            $_SESSION['currentPage'] = "novaVstupenka";
        }else {
            $_SESSION['currentPage'] = "programy";
        }

    } else {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>KinoAdmin</title>
    <link rel="stylesheet" href="adminStyle.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

</head>
<body>

<header>
    <h1>Admin panel</h1>
</header>

<div class="navFlex">
    <nav class="navigace">
        <form action="" method="post">
            <input name="programySubmit" value="Programy" type="submit">
            <input name="vstupenkySubmit" value="Vstupenky" type="submit">
            <input name="novyFilmSubmit" value="Nový film" type="submit">
            <input name="novaVstupenkaSubmit" value="Nová vstupenka" type="submit">

        </form>
        <!--            <button onclick="--><?php //$vybranaTabulka = 1 ?><!--">Programy</button>-->
        <!--            <button onclick="--><?php //$vybranaTabulka = 2 ?><!--">Rezervace</button>-->
        <!--            <button onclick="--><?php //$vybranaTabulka = 3 ?><!--">Vstupenky</button>-->
    </nav>
</div>

<main class="mainContent">
    <div class="tableContent">
        <?php

        if (isset($_SESSION['uzivatel'])) {
            if ($_SESSION['uzivatel'] == "admin") {

                switch ($_SESSION['currentPage']) {
                    case "programy":
                        include "programy.php";
                        break;
                    case "rezervace":
                        include "rezervace.php";
                        break;
                    case "vstupenky":
                        include "vstupenky.php";
                        break;
                    case "novyFilm":
                        include "novyFilm.php";
                        break;
                    case "novaVstupenka":
                        header("Location: novaVstupenka.php");
                        break;
                }
            } else {
                header("Location: index.php");
            }
        }
        ?>
    </div>

</main>


<!--    jQuerry a plugin tableEdit-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="jsLib/jquery.tabledit.js"></script>
<script type="text/javascript" src="js/tableEditVstupenky.js"></script>
<script type="text/javascript" src="js/tableEditProgramy.js"></script>
</body>
</html>

