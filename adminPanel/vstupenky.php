
<table id="vstupenkyTable" class="table table-striped">
    <thead>
    <th>ID</th>
    <th>ID vstupenky</th>
    <th>ID filmu</th>
    <th>ID rezervace</th>
    <th>Číslo sedadla</th>
    <th>Vstupní kód</th>
    </thead>
    <tbody>
    <?php
    include "../dbconnect.php";
    $sql = "SELECT id,id_vstupenky,id_filmu,id_rezervace,cisloSedadla,vstupniKod FROM vstupenky";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['id_vstupenky']."</td>";
            echo "<td>".$row['id_filmu']."</td>";
            echo "<td>".$row['id_rezervace']."</td>";
            echo "<td>".$row['cisloSedadla']."</td>";
            echo "<td>".$row['vstupniKod']."</td>";
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>