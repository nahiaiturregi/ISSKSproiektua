<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

if(!$conn){
    die("Konexio galduta:" .mysqli_connect_error());
}

//item-aren id-a hartu URL-tik eta ezabatu
if (isset($_GET['item'])) {
    $item = $_GET['item'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'bai') {
        //Erabiltzaileak ezabaketa onartzen du
        $sql = "DELETE FROM FunkoPop WHERE id = $item";

        if ($conn->query($sql) === TRUE) {
            header("Location: items.php"); //items.php-ra bideratu
            exit();
        } else {
            echo "Ezin izan da elementua ezabatu: " . $conn->error;
        }
    } elseif (isset($_GET['confirm']) && $_GET['confirm'] === 'ez') {
        //Erabiltzaileak ezabaketa ez duela onartzen adierazi du
        header("Location: items.php");
        exit();
    } else {
        // Konfirmazioa eskatu
        echo "<form method='get' action='delete_item.php'>";
        echo "<input type='hidden' name='item' value='$item'>";
        echo "Elementu hau ezabatu nahi duzu?";
        echo "<br>";
        echo "<button type='submit' name='confirm' value='ez'>Ez</button>";
        echo "<button type='submit' id='item_delete_submit' name='confirm' value='bai'>Bai</button>";
        echo "</form>";
    }
} else {
    echo "Ez da elementurik aukeratu.";
}

$conn->close();
?>
