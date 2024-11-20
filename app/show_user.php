<?php
include('session_config.php');

//Zifraketa funtzioak kargatu
require_once('zifraketa.php');

session_start();
$max_inactivity_time = 900;

if (isset($_SESSION['last_activity'])) {
    $inactivity_duration = time() - $_SESSION['last_activity'];
    if ($inactivity_duration > $max_inactivity_time) {
        session_unset();
        session_destroy();
		header("Location: login.php?timeout=1"); 
        exit();
    }
}

$_SESSION['last_activity'] = time(); // Actualizar la última actividad

if (isset($_GET['timeout']) && $_GET['timeout'] == '1') {
			header("Location: login.php");
}

//DB-arekin konexioa sortu
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

if(!$conn){
    die("Konexio galduta:" .mysqli_connect_error());
}

//Egiaztatu ea URLan erabiltzaile bat zehaztuta dagoen, saioa hasita dagoen eta URLan zehaztutako erabiltzailearen IDa eta saioan hasitako erabiltzailearen IDa berdinak diren
if (isset($_GET['user']) && isset($_SESSION['user']) && intval($_GET['user']) === intval($_SESSION['user'])) {
    $user = $_GET['user'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            //Datuak desenkriptatu
            $email = decrypt($row['email']);
            $telefonoa = decrypt($row['telefonoa']);
            $nan = decrypt($row['nan']);
            $jaiotze_data = decrypt($row['jaiotze_data']);

            echo "Izena: " . $row['nombre'] . "<br>";
            echo "NAN: " . $nan . "<br>";
            echo "Telefonoa: " . $telefonoa . "<br>";
            echo "Jaiotze-data: " . $jaiotze_data . "<br>";
            echo "Email: " . $email . "<br>";
            $id = $row['id'];
            echo '<a href="modify_user.php?user=' . $id . '" style="text-decoration: none;">';
            echo '<button type="button">Datuak aldatu</button>';
            echo '</a>';
        }
        echo '<a href="/" style="text-decoration: none;">';
        echo '<button type="button">Hasierara itzuli</button>';
        echo '</a>';
    } else {
        echo "Ez da erabiltzailea aurkitu.";
    }
    $stmt->close();
} else {
    echo "Ez da erabiltzailea aurkitu.";
}

$conn->close();
?>
