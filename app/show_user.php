<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

if(!$conn){
    die("Konexio galduta:" .mysqli_connect_error());
}

if (isset($_GET['user'])) {
    $user = $_GET['user'];

    $sql = "SELECT * FROM usuarios WHERE id = $user";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Izena: " . $row['nombre'] . "<br>";
            echo "NAN: " . $row['nan'] . "<br>";
            echo "Telefonoa: " . $row['telefonoa'] . "<br>";
            echo "Jaiotze-data: " . $row['jaiotze_data'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Pasahitza: " . $row['pasahitza'] . "<br>";
            $id = $row['id'];
            echo '<a href="modify_user.php?user=' . $id . '" style="text-decoration: none;">';
            echo '<button type="button">Datuak aldatu</button>';
            echo '</a>';
        }
    } else {
        echo "Ez da erabiltzailea aurkitu.";
    }
} else {
    echo "Ez da elementurik aukeratu.";
}

$conn->close();
?>