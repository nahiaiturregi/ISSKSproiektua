<?php

include_once('config.php'); 

$hostname = "db";
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');
$db = getenv('MYSQL_DATABASE');

//Datu-basera konektatu
$conn = mysqli_connect($hostname, $username, $password, $db);

//Konexioa huts egitekotan, errore-mezua agertu:
if (!$conn) {
    die("Konexio galduta: " . mysqli_connect_error());
}

//Egiaztatu ea URLak item parametro bat duen, erakutsi nahi den itemaren IDa zehazten duena
if (isset($_GET['item'])) {
    //Itemaren IDa hartu URLtik. IDa datu-basean itema bilatzeko erabiliko da
    $item_id = $_GET['item'];

    //FunkoPop taulan bilatu IDa duen itema
    $stmt = $conn->prepare("SELECT * FROM FunkoPop WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
 
    //Kontsultak emaitzaren bat itzuli duen egiaztatu, hau da, ID hori duen itema dagoen:
    if (mysqli_num_rows($result) > 0) {
    	//Itema aurkitzen bada, emaitza gisa itzuli den errenkada array asoziatibo bihurtzen du, non gako bakoitza taulako zutabe baten izenari dagokion: 
        $row = mysqli_fetch_assoc($result);
        // Itemaren xehetasunak erakutsi:
        echo "<h1>Figuraren xehetasunak:</h1>";
        echo "<p><strong>ID:</strong> " . $row['id'] . "</p>";
        echo "<p><strong>Izena:</strong> " . $row['izena'] . "</p>";
        echo "<p><strong>Mota:</strong> " . $row['mota'] . "</p>";
        echo "<p><strong>Tamaina:</strong> " . $row['tamaina'] . "</p>";
        echo "<p><strong>Prezioa:</strong> $" . $row['prezioa'] . "</p>";
        //Itema editatzeko fitxategira daraman esteka erakutsi:
        echo "<form method='get' action='modify_item.php'>";
            echo "<input type='hidden' name='item' value='" . $row['id'] . "'>";
            echo "<button type='submit'>Editatu</button>";
        echo "</form>";
        echo "<p>   </p>";
        //Zerrendara itzultzeko esteka erakutsi:
        echo "<form method='post' action='items.php'>";
                echo "<button type='submit'>Itzuli zerrendara</button>";
        echo "</form>";
    } else {
        echo "<p>Ez da FunkoPop-a aurkitu.</p>";
    }
    $stmt->close();
} else {
    echo "<p>Ez da elementurik aukeratu.</p>";
}

mysqli_close($conn);
?>

