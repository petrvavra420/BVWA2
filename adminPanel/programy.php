
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
            echo "<td>".$row['id_filmu']."</td>";
            echo "<td>".$row['id_rezervace']."</td>";
            echo "<td>".$row['je_3d']."</td>";
            echo "<td>".$row['nazev']."</td>";
            echo "<td>".$row['zacatek']."</td>";
            echo "<td>".$row['konec']."</td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

