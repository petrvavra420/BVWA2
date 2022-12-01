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

        </form>
        <!--            <button onclick="--><?php //$vybranaTabulka = 1 ?><!--">Programy</button>-->
        <!--            <button onclick="--><?php //$vybranaTabulka = 2 ?><!--">Rezervace</button>-->
        <!--            <button onclick="--><?php //$vybranaTabulka = 3 ?><!--">Vstupenky</button>-->
    </nav>
</div>

<main>
    <?php
    session_start();
    if (isset($_SESSION['uzivatel'])) {
        if ($_SESSION['uzivatel'] == "admin") {
            if (isset($_POST['programySubmit'])) {
                include "programy.php";
            } else if (isset($_POST['rezervaceSubmit'])) {
                include "rezervace.php";
            } else if (isset($_POST['vstupenkySubmit'])) {
                include "vstupenky.php";
            }
        } else {
            header("Location: index.php");
        }
    }
    ?>

</main>


<!--    jQuerry a plugin tableEdit-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript" src="jsLib/jquery.tabledit.js"></script>
<script type="text/javascript" src="js/tableEditVstupenky.js"></script>
<script type="text/javascript" src="js/tableEditProgramy.js"></script>
</body>
</html>

