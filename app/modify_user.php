<?php
session_start();

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

//Egiaztatu ea URLan aldatuko den erabiltzailearen "user_id"-a bidali den, eta ea saioa aktibo dagoen erabiltzaileak saioa hasi egin duela ziurtatzeko
if(isset($_GET['user']) && isset($_SESSION['user'])){
	//URltik aldatuko den erabiltzailearen IDa lortu:
	$user_id=$_GET['user'];
	
	//Erabiltzailearen uneko datuak lortzeko kontsulta (IDaren arabera)
	$query="SELECT * FROM usuarios WHERE id='$user_id'";
	$result=mysqli_query($conn, $query);
	
	//Kontsultaren emaitza array asoziatiboan bihurtu (eremu bakoitzak gako-izen bat duen array-a):
	$usuario=mysqli_fetch_assoc($result); 
	
	//Erabiltzailea aurkitzen ez bada, mezua pantailaratu eta script amaitu:
	if(!$usuario){
		echo "Erabiltzaile ez aurkitua.";
		exit();
	}
	
	//Formularioa prozesatu datuak aldatzeko
	if($_SERVER['REQUEST_METHOD']=='POST'){
		//Formularioan $_POST bidez bidalitako datuak atera:
		$nombre=$_POST['nombre'];
		$nan=$_POST['nan'];
		$telefonoa=$_POST['telefonoa'];
		$jaiotze_data=$_POST['jaiotze_data'];
		$email=$_POST['email'];
		
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
        	
        	//Erabiltzailearen datuak datu-basean eguneratu:
		$query="UPDATE usuarios SET
			nombre='$nombre',
			nan='$nan',
			telefonoa='$telefonoa',
			jaiotze_data='$jaiotze_data',
			email='$email'
			WHERE id='$user_id'";
		
		//Eguneratze-kontsulta gauzatu. Arrakastatsua bada, berrespen-mezu bat erakutsi:
		if (mysqli_query($conn, $query)) {
            		echo "Datuak eguneratu dira.";
        	} else {
        		//Eguneratzerakoan errore baten bat badago, errorea erakutsi:
           		 echo "Errorea: " . mysqli_error($conn);
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
    Nombre: <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>
    NAN: <input type="text" name="nan" value="<?php echo $usuario['nan']; ?>" pattern="[0-9]{8}-[A-Z]" required><br>
    Telefonoa: <input type="text" name="telefonoa" value="<?php echo $usuario['telefonoa']; ?>" pattern="[0-9]{9}" required><br>
    Jaiotze-data: <input type="date" name="jaiotze_data" value="<?php echo $usuario['jaiotze_data']; ?>" required><br>
    Correo Electrónico: <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>
    <input id="user_modify_submit" type="submit" value="Aldaketak gorde">
</form>

</body>
</html>

