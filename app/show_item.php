<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

if (!$conn) {
    die("Konexio galduta: " . mysqli_connect_error());
}

if (isset($_GET['item'])) {
    $item_id = $_GET['item'];

    $sql = "SELECT * FROM FunkoPop WHERE id = $item_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Mostrar los detalles del ítem
        $row = mysqli_fetch_assoc($result);
        echo "<h1>Figuraren xehetasunak:</h1>";
        echo "<p><strong>ID:</strong> " . $row['id'] . "</p>";
        echo "<p><strong>Izena:</strong> " . $row['izena'] . "</p>";
        echo "<p><strong>Mota:</strong> " . $row['mota'] . "</p>";
        echo "<p><strong>Tamaina:</strong> " . $row['tamaina'] . "</p>";
        echo "<p><strong>Prezioa:</strong> $" . $row['prezioa'] . "</p>";
        echo '<a href="items.php">Itzuli Funko Pop zerrendara</a>';
    } else {
        echo "<p>Ez da elementua aurkitu.</p>";
    }
} else {
    echo "<p>Ez da elementurik aukeratu.</p>";
}

mysqli_close($conn);
?>

