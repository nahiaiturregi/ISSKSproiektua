<?php
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

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
    $sql = "SELECT * FROM FunkoPop WHERE id = $item_id";
    $result = mysqli_query($conn, $sql);
 
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
        //Itema editzteko fitxategira daraman esteka erakutsi:
        echo '<a href="modify_item.php?item=' .$row['id']. '">Editatu</a>';
        //Zerrendara itzultzeko esteka erakutsi:
        echo '<a href="items.php">Itzuli Funko Pop zerrendara</a>';
    } else {
        echo "<p>Ez da FunkoPop-a aurkitu.</p>";
    }
} else {
    echo "<p>Ez da elementurik aukeratu.</p>";
}

mysqli_close($conn);
?>

