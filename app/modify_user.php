<?php
session_start();

$hostname="db";
$username="admin";
$password="test";
$db="database";

$conn=mysqli_connect($hostname, $username, $password, $db);
if($conn->connect_error){
	die("Huts egindako konexioa: " . $conn->connect_error);
}

//Erabiltzaile bat eman den egiaztatu
//Si accedes a modify_user.php?user=1, $_GET['user'] será 1
if(isset($_GET['user'])){
	$user_id=$_GET['user'];
	
	//Obtener los datos actuales del usuario
	$query="SELECT * FROM usuarios WHERE id='$user_id'";
	$result=mysqli_query($conn, $query);
	
	//convierte el resultado de la consulta en un array asociativo: un array donde cada campo tiene un nombre clave ('nombre', 'email',etc.):
	$usuario=mysqli_fetch_assoc($result); 

	if(!$usuario){
		echo "Erabiltzaile ez aurkitua.";
		exit();
	}
	
	//Formularioa prozesatu datuak aldatzeko
	//Se extrae los datos enviados en el formulario a través de $_POST
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$nombre=$_POST['nombre'];
		$nan=$_POST['nan'];
		$telefonoa=$_POST['telefonoa'];
		$jaiotze_data=$_POST['jaiotze_data'];
		$email=$_POST['email'];
		
		//Datuak balioztatu
		if(!preg_match("/^[0-9]{8}-[A-Z]$/", $nan)){
			echo "NAN formatu baliogabea.";
			exit();
		}
		if (!preg_match("/^[0-9]{9}$/", $telefonoa)) {
           		echo "9 digituko telefonoa sartu behar duzu.";
            		exit();
       		}
        	if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $jaiotze_data)) {
            		echo "Data formatu baligabea(uuuu-hh-ee).";
            		exit();
        	}
        	
        	//Datu basean erabiltzailearen datuak eguneratu
		$query="UPDATE usuarios SET
			nombre='$nombre',
			nan='$nan',
			telefonoa='$telefonoa',
			jaiotze_data='$jaiotze_data',
			email='$email'
			WHERE id='$user_id'";
			
		if (mysqli_query($conn, $query)) {
            		echo "Datuak eguneratu dira.";
        	} else {
           		 echo "Errorea: " . mysqli_error($conn);
        	}
	}
} else {
	echo "Ez da erabiltzailerik zehaztu.";
	exit();
}

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

