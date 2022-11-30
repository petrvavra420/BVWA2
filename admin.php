<?php
    session_start();
    if (isset($_SESSION['uzivatel'])){
        if ($_SESSION['uzivatel'] == "admin"){
            echo "OK";
        }else {
            header("Location: index.php");
        }
    }
?>


