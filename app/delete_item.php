<?php
ob_start(); //Irteera buffer-a hasieratu
require 'auth.php';
require 'anti_CSRF.php';
require 'sanitize.php';

checkAdmin(); //Erabiltzaileak admin baimena duen egiaztatu
$token_antiCSRF = sortuTokenAntiCSRF(); //CSRF erasoen kontra token bat sortu edo lortu

include('timeout.php'); //Saioaren iraupena kontrolatzeko

$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

if ($conn->connect_error) {
    die("Huts egindako konexioa: " . $conn->connect_error);
}

// Frogatu ID zenbaki bat dela
$item = filter_var($_GET['item'], FILTER_VALIDATE_INT);
if ($item === false) {
    ob_end_clean();
    echo "ID ez da onargarria.";
    exit();
}

// Item honen datuak lortu bere id-a erabiliz
$stmt = $conn->prepare("SELECT * FROM FunkoPop WHERE id = ?");
$stmt->bind_param("i",$item);
$stmt->execute();
$result = $stmt->get_result();

//Kontsulta hau egin eta gero emaitzarik ez badira agertzen errore bat egon da, edo ez dago id honekin elementurik datu basean
if (!$result || mysqli_num_rows($result) == 0) {
    ob_end_clean();
    die("Errorea elementua aurkitzeko: " . mysqli_error($conn));
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $S_POST = sanitize_array($_POST);
    $jasotako_tokena = $S_POST['token_antiCSRF'] ?? '';
        if (!egiaztatuTokenAntiCSRF($jasotako_tokena)) {
            ob_end_clean();
            die ("Ezin da sarbidea onartu.");
        }
    if (isset($S_POST['confirm']) && $S_POST['confirm'] === 'Bai') {
        //Erabiltzaileak ezabaketa onartzen du
        echo("BAI");
        $stmt = $conn->prepare("DELETE FROM FunkoPop WHERE id = ?");
        $stmt->bind_param("i", $item);
        $stmt->execute();

        if ($stmt->execute()) {
            header("Location: items.php"); //items.php-ra bideratu
            exit();
        } else {
            echo "Ezin izan da elementua ezabatu: " . $stmt->error;
        }
    } elseif (isset($S_POST['confirm']) && $S_POST['confirm'] === 'Ez') {
        //Erabiltzaileak ezabaketa ez duela onartzen adierazi du
        header("Location: items.php");
        exit();
    }
}

$stmt->close();
$conn->close();
ob_end_flush();//Buffer amaitu
?>

<!DOCTYPE html>
<html>
<body>
    <form id="delete_item_form" action="delete_item.php?item=<?php echo $item; ?>" method="POST">
        Elementu hau ezabatu nahi duzu?<br>
        <input type="hidden" name="token_antiCSRF" value="<?php echo htmlspecialchars($token_antiCSRF); ?>">
        <input id="delete_item_submit" name="confirm" type="submit" value="Bai">
        <input name="confirm" type="submit" value="Ez">
    </form>
</body>
</html>