<?php
//Erabiltzaileak admin baimena duen egiaztatu
require 'auth.php';
checkAdmin();

//X-Frame-Options segurtasunerako
header("X-Frame-Options: SAMEORIGIN");
//CSP segurtasunerako
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
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

    // Frogatu ID zenbaki bat dela
    $item = filter_var($_GET['item'], FILTER_VALIDATE_INT);
    if ($item === false) {
        echo "ID ez da onargarria.";
        exit();
    }

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'bai') {
        //Erabiltzaileak ezabaketa onartzen du
        $stmt = $conn->prepare("DELETE FROM FunkoPop WHERE id = ?");
        $stmt->bind_param("i", $item);
        $stmt->execute();

        if ($stmt->execute()) {
            header("Location: items.php"); //items.php-ra bideratu
            exit();
        } else {
            echo "Ezin izan da elementua ezabatu: " . $stmt->error;
        }
    } elseif (isset($_GET['confirm']) && $_GET['confirm'] === 'ez') {
        //Erabiltzaileak ezabaketa ez duela onartzen adierazi du
        header("Location: items.php");
        exit();
    } else {
        // item balio eskapatu, karakter bereziak html entitate seguruetan bihurtzeko
        $item_escaped = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
        // Konfirmazioa eskatu
        echo "<form method='get' action='delete_item.php'>";
        echo "<input type='hidden' name='item' value='$item_escaped'>";
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
