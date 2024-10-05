<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

if(!$conn){
    die("Konexio galduta:" .mysqli_connect_error());
}

if (isset($_GET['item'])) {
    $item = $_GET['item'];

    $sql = "DELETE FROM FunkoPop WHERE id = $item";

    if ($conn->query($sql) === TRUE) {
        header("Location: items.php");
        exit();
    } else {
        echo "Ezin izan da elementua ezabatu: " . $conn->error;
    }
} else {
    echo "Ez da elementurik aukeratu.";
}

$conn->close();
?>
