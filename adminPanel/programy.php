<input id="hledejFilmInput" type="text" onkeyup="vyhledejNazev()" placeholder="Vyhledat pomocí názvu filmu">
<table id="programyTable" class="table table-striped">
    <thead>
    <th>ID filmu</th>
    <th>ID rezervace</th>
    <th>Je 3D</th>
    <th>Název</th>
    <th>Začátek</th>
    <th>Konec</th>
    </thead>
    <tbody>


    <?php
    include "../dbconnect.php";
    $sql = "SELECT id_filmu,id_rezervace,je_3d,nazev,zacatek,konec FROM program";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_filmu'] . "</td>";
            echo "<td>" . $row['id_rezervace'] . "</td>";
            echo "<td>" . $row['je_3d'] . "</td>";
            echo "<td>" . $row['nazev'] . "</td>";
            echo "<td>" . $row['zacatek'] . "</td>";
            echo "<td>" . $row['konec'] . "</td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

<script>
    function vyhledejNazev() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("hledejFilmInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("programyTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

