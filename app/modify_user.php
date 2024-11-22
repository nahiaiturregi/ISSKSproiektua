<?php
require 'anti_CSRF.php';
require_once('zifraketa.php'); //Zifraketa funtzioak kargatu

include('session_config.php');
include('timeout.php'); //Saioaren iraupena kontrolatzeko

$token_antiCSRF = sortuTokenAntiCSRF(); //CSRF erasoen kontra token bat sortu edo lortu

$hostname="db";
$username="admin";
$password="test";
$db="database";

//Datu-basera konektatu
$conn=mysqli_connect($hostname, $username, $password, $db);

//Konexioa huts egitekotan, errore-mezua agertu eta amaitu scripta
if($conn->connect_error){
	die("Huts egindako konexioa: " . $conn->connect_error);
}

// GET eta POST emaitza saneatzeko funtzioa
function sanitize_array($data) {
    $sanitized_data = [];
    foreach ($data as $key => $value) {
        $sanitized_data[$key] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }
    return $sanitized_data;
}

//Egiaztatu ea URLan erabiltzaile bat zehaztuta dagoen, saioa hasita dagoen eta URLan zehaztutako erabiltzailearen IDa eta saioan hasitako erabiltzailearen IDa berdinak diren
if(isset($_GET['user']) && isset($_SESSION['user']) && intval($_GET['user']) === intval($_SESSION['user'])){
	//URltik aldatuko den erabiltzailearen IDa lortu:
	$user_id = filter_var($_GET['user'], FILTER_VALIDATE_INT);
	if ($user_id === false) {
        echo "ID ez da onargarria.";
        exit();
    }
	
	//Erabiltzailearen uneko datuak lortzeko kontsulta (IDaren arabera)
	$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id= ?");
	$stmt->bind_param("i",$user_id);
	$stmt->execute();
	$result = $stmt->get_result();
	
	//Kontsultaren emaitza array asoziatiboan bihurtu (eremu bakoitzak gako-izen bat duen array-a):
	$usuario=mysqli_fetch_assoc($result); 
	
	//Erabiltzailea aurkitzen ez bada, mezua pantailaratu eta script amaitu:
	if(!$usuario){
		echo "Erabiltzaile ez aurkitua.";
		exit();
	}

	//Datuak deszifratu
	$usuario['nan'] = decrypt($usuario['nan']);
	$usuario['telefonoa'] = decrypt($usuario['telefonoa']);
	$usuario['jaiotze_data'] = decrypt($usuario['jaiotze_data']);
	$usuario['email'] = decrypt($usuario['email']);
	
	//Formularioa prozesatu datuak aldatzeko
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$S_POST = sanitize_array($_POST);
		$jasotako_tokena = $S_POST['token_antiCSRF'] ?? '';
        if (!egiaztatuTokenAntiCSRF($jasotako_tokena)) {
            echo "Ezin da sarbidea onartu.";
            exit();
        }

		//Formularioan $_POST bidez bidalitako datuak atera:
		$nombre=$S_POST['nombre'];
		$nan=$S_POST['nan'];
		$telefonoa=$S_POST['telefonoa'];
		$jaiotze_data=$S_POST['jaiotze_data'];
		$email=$S_POST['email'];
		
		//NANaren formatu zuzena dela egiaztatu:
		if(!preg_match("/^[0-9]{8}-[A-Z]$/", $nan)){
			echo "NAN formatu baliogabea.";
			exit();
		}
		
		//Telefonoaren formatu zuzena dela egiaztatu:
		if (!preg_match("/^[0-9]{9}$/", $telefonoa)) {
           		echo "9 digituko telefonoa sartu behar duzu.";
            		exit();
       		}
       		
       		//Jaiotze-dataren formatu zuzena dela egiaztatu:
        	if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $jaiotze_data)) {
            		echo "Data formatu baliogabea(uuuu-hh-ee).";
            		exit();
        	}
		
		//Datu berriak zifratu:
		$encrypted_nan = encrypt($nan);
		$encrypted_telefonoa = encrypt($telefonoa);
		$encrypted_jaiotze_data = encrypt($jaiotze_data);
		$encrypted_email = encrypt($email);
        	
        	//Erabiltzailearen datuak datu-basean eguneratu:
		$stmt = $conn->prepare("UPDATE usuarios SET nombre= ?, nan= ?, telefonoa= ?, jaiotze_data= ?, email= ? WHERE id= ?");
		$stmt->bind_param("sssssi", $nombre, $encrypted_nan, $encrypted_telefonoa, $encrypted_jaiotze_data, $encrypted_email, $user_id);
		$stmt->execute();

		//Eguneratze-kontsulta gauzatu. Arrakastatsua bada, berrespen-mezu bat erakutsi:
		if ($stmt->execute()) {
            header("Location: show_user.php?user=$user_id");
			exit();
        } else {
			//Eguneratzerakoan errore baten bat badago, errorea erakutsi:
           	echo "Errorea: " . $stmt->error;
        }
	}
} else {
	//Erabiltzaile bat eman en bada edo saioa hasi ez bada, errore-mezu bat agertu:
	echo "Ez da erabiltzailerik zehaztu.";
	exit();
}
//Datu-baserako konexioa itxi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Erabiltzailearen datuak aldatu</title>
</head>
<body>

<h2>Erabiltzailearen datuak aldatu</h2>

<form id="user_modify_form" action="modify_user.php?user=<?php echo $user_id; ?>" method="POST">
    Izena: <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>
    NAN: <input type="text" name="nan" value="<?php echo $usuario['nan']; ?>" pattern="[0-9]{8}-[A-Z]" required><br>
    Telefonoa: <input type="text" name="telefonoa" value="<?php echo $usuario['telefonoa']; ?>" pattern="[0-9]{9}" required><br>
    Jaiotze-data: <input type="date" name="jaiotze_data" value="<?php echo $usuario['jaiotze_data']; ?>" required><br>
    Posta elektronikoa: <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>
    <input id="user_modify_submit" type="submit" value="Aldaketak gorde">
	<input type="hidden" name="token_antiCSRF" value="<?php echo htmlspecialchars($token_antiCSRF); ?>">
</form>

</body>
</html>

