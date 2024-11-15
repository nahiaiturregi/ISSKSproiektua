<?php
//Erabiltzaileak admin baimena duen egiaztatu
require 'auth.php';
checkAdmin();

//X-Frame-Options segurtasunerako
header("X-Frame-Options: SAMEORIGIN");
//CSP segurtasunerako
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
//Datu basera konektatzeko
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

//Konexioa egiaztatu
if(!$conn){
    die("Konexio galduta:" .mysqli_connect_error());
}

//Formularioa bete ondoren datuak sartu
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Lortu datuak
    $id = $_POST['id'];
    $izena = $_POST['izena'];
    $mota = $_POST['mota'];
    $tamaina = $_POST['tamaina'];
    $prezioa = $_POST['prezioa'];

    //ID errepikatuta dagoen egiaztatu
    $stmt = $conn->prepare("SELECT * FROM FunkoPop WHERE id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('ID hori duen elementua jada existitzen da.');</script>";
        exit();
    }
    else{
        //Errepikatuta ez badago, elementu berria sartu
        $stmt = $conn->prepare("INSERT INTO FunkoPop (id, izena, mota, tamaina, prezioa) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $id, $izena, $mota, $tamaina, $prezioa);
        if(!$stmt->execute()){
            die("Errorea kontsultan: " . $stmt->error);
        } else {
            header("Location: /");
            exit();
        }
    }

    $stmt->close();
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Itemak gehitu</title>
</head>
<body>
    <h1>Itemak gehitu</h1>
    <script src="js/add_item.js" defer></script> 
    <form name="item_add_form" id="item_add_form" method="POST" action="">
        <label>Id:</label><br>
        <input type="text" name="id"><br>
        <label>Izena:</label><br>
        <input type="text" name="izena"><br>
        <label>Mota:</label><br>
        <input type="text" name="mota"><br>
        <label>Tamaina:</label><br>
        <input type="text" name="tamaina"><br>
        <label>Prezioa:</label><br>
        <input type="text" name="prezioa"><br>
        <input type="button" name="item_add_submit" id="item_add_submit" value="Gehitu">
        <input type="button" value="Hasierara itzuli" id="reset_button">
        <input type="hidden" name="bidalita" value="0">
    </form>
</body>
</html>
