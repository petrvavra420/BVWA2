<?php
//přihlášení do sekce správce
if (isset($_POST['adminSubmit'])) {
    if (!empty($_POST['login']) && !empty($_POST['heslo'])) {
        //ošetření vstupu
        $login = test_input($_POST['login']);
        $heslo = test_input($_POST['heslo']);
        $hesloHashed = md5($heslo);

        //kontrola údajů v databázi
        include_once("../dbconnect.php");
        $sql = "SELECT * FROM admin WHERE login = '$login' AND heslo = '$hesloHashed'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            session_start();
            //pokud se našly stejné údaje, nastaví session var a přesměruje admina
            $_SESSION['uzivatel'] = "admin";
            header("Location: admin.php");
            echo "TEST";
        } else {
            echo '<script>alert("Špatné přihlašovací údaje.")</script>';
        }

    } else {
        //jméno nebo heslo je prázdné
        echo '<script>alert("Jméno nebo heslo je prázdné")</script>';
    }
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<head>
    <style>
        body {
            background-color: #363537;
            margin: 0;
        }

        main {
            display: flex;
            justify-content: center;
        }

        header {
            color: #E0E2DB;
            font-family: "Segoe UI";
            margin-bottom: 1em;
            display: block;
            height: auto;
            padding: 0.2em;
            text-align: center;
            background-color: #06A77D;
        }

        form {
            color: #E0E2DB;
            font-family: "Segoe UI";
            margin: 1em;
            text-align: center;
        }

        .loginMenu {
            margin-top: 1em;
            scale: 1.2;
            padding-top: 2em;
            padding-bottom: 2em;
            display: block;
            background-color: #242426;
        }

        .submitBtn {
            background-color: #06A77D;
            border: none;
            color: #E0E2DB;
            margin-top: 1em;
            border-radius: 0.2em;
            padding: 0.5em;
            padding-left: 1em;
            padding-right: 1em;
            font-family: "Segoe UI";
        }

        .submitBtn:hover {
            cursor: pointer;
            background-color: #E0E2DB;
            color: #06A77D;
        }

        h2 {
            text-align: center;
            color: #E0E2DB;
            font-family: "Segoe UI";
        }

        .inputy {
            display: block;
            margin-top: 0.4em;

        }

        .inputy * {
            padding: 0.4em;
        }


    </style>
</head>
<header>
    <h1>Admin panel</h1>
</header>
<main>
    <div class="loginMenu">
        <h2>Přihlášení</h2>
        <form method="post" action="">
            <span class="inputy"> <input placeholder="Login" name="login" type="text"> <br></span>
            <span class="inputy"> <input placeholder="Heslo" name="heslo" type="password"> <br></span>

            <input class="submitBtn" name="adminSubmit" value="Přihlásit" type="submit">
        </form>
    </div>
</main>


