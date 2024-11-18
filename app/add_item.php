<?php
ob_start(); //Irteerako buffer bat hasieratu 

require 'auth.php';
require 'anti_CSRF.php';

checkAdmin(); //Erabiltzaileak admin baimena duen egiaztatu
$token_antiCSRF = sortuTokenAntiCSRF(); //CSRF erasoen kontra token bat sortu edo lortu

session_start();
$max_inactivity_time = 10;

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

//Datu basera konektatzeko
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

//Konexioa egiaztatu
if(!$conn){
    ob_end_clean();
    die("Konexio galduta:" .mysqli_connect_error());
}

// GET eta POST emaitza saneatzeko funtzioa
function sanitize_array($data) {
    $sanitized_data = [];
    foreach ($data as $key => $value) {
        $sanitized_data[$key] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }
    return $sanitized_data;
}

//Formularioa bete ondoren datuak sartu
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Lortu datuak
    $S_POST = sanitize_array($_POST);
    $jasotako_tokena = $S_POST['token_antiCSRF'] ?? '';
        if (!egiaztatuTokenAntiCSRF($jasotako_tokena)) {
            echo "Ezin da sarbidea onartu.";
            exit();
        }
    $id = $S_POST['id'];
    $izena = $S_POST['izena'];
    $mota = $S_POST['mota'];
    $tamaina = $S_POST['tamaina'];
    $prezioa = $S_POST['prezioa'];

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
ob_end_flush(); //Irteerako buffer-a amaitu
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
        <input type="hidden" name="token_antiCSRF" value="<?php echo htmlspecialchars($token_antiCSRF); ?>">
    </form>
</body>
</html>
