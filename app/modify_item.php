<?php
ob_start();//Irteera buffer-a hasieratu
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

// Datu basearekin konektatu
$hostname = "db";
$username = "admin";
$password = "test";
$db = "database";

$conn = mysqli_connect($hostname, $username, $password, $db);

// Konexioa egiaztatu
if (!$conn) {
    die("Errorea konexioan: " . mysqli_connect_error());
}

// GET eta POST emaitza saneatzeko funtzioa
function sanitize_array($data) {
    $sanitized_data = [];
    foreach ($data as $key => $value) {
        $sanitized_data[$key] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }
    return $sanitized_data;
}

// Editatu nahi den itemaren ID-a lortu ID-a zenbaki bat dela frogatuz
$item_id = filter_var($_GET['item'], FILTER_VALIDATE_INT);
if ($item_id === false) {
    ob_end_clean();
    die("ID ez da onargarria.");
}

// Item honen datuak lortu bere id-a erabiliz
$stmt = $conn->prepare("SELECT * FROM FunkoPop WHERE id = ?");
$stmt->bind_param("i",$item_id);
$stmt->execute();
$result = $stmt->get_result();

//Kontsulta hau egin eta gero emaitzarik ez badira agertzen errore bat egon da, edo ez dago id honekin elementurik datu basean
if (!$result || mysqli_num_rows($result) == 0) {
    ob_end_clean();
    die("Errorea elementua aurkitzeko: " . mysqli_error($conn));
}

// Lortutako datuak array batean sartu, non gakoak zutabeen izenak diren eta datuak zutabe hauen edukia
$item = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $S_POST = sanitize_array($_POST);
    $jasotako_tokena = $S_POST['token_antiCSRF'] ?? '';
        if (!egiaztatuTokenAntiCSRF($jasotako_tokena)) {
            ob_end_clean();
            die ("Ezin da sarbidea onartu.");
        }
    $izena = $S_POST['izena'];
    $mota = $S_POST['mota'];
    $tamaina = $S_POST['tamaina'];
    $prezioa = $S_POST['prezioa'];

    //Datu basean erabiltzailearen datuak eguneratu

    $stmt = $conn->prepare("UPDATE FunkoPop SET izena = ?, mota = ?, tamaina = ?, prezioa = ? WHERE id = ?");
    $stmt->bind_param("sssdi", $izena, $mota, $tamaina, $prezioa, $item_id);

    if ($stmt->execute()) {
        header("Location: show_item.php?item=$item_id");
        exit();
    } else {
        ob_end_clean();
        die("Errorea: " . $stmt->error);
    }
}

$stmt->close();
mysqli_close($conn);
ob_end_flush();//Irteera buffer-a amaitu
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editatu Funko Pop</title>
</head>
<body>
    <h1>Editatu Funko Pop</h1>

    <!-- Datuak aldatzeko sortutako formularioa, automatikoki datu basean gordetako balioekin beteko dena-->
    <!-- Datuak eskapatzen dira, html karaktere bereziak zuzenean ez irakurtzeko-->
    <form id="item_modify_form" action="modify_item.php?item=<?php echo $item_id; ?>" method="POST">
        Izena: <input type="text" name="izena" value="<?php echo $item['izena']; ?>" required><br>
        Mota: <input type="text" name="mota" value="<?php echo $item['mota']; ?>" required><br>
        Tamaina: <input type="text" name="tamaina" value="<?php echo $item['tamaina']; ?>" required><br>
        Prezioa: <input type="text" name="prezioa" value="<?php echo $item['prezioa']; ?>" pattern="^\d+(\.\d{1,2})?$" required><br>
        <input type="hidden" name="token_antiCSRF" value="<?php echo htmlspecialchars($token_antiCSRF); ?>">
        <input id="item_modify_submit" type="submit" value="Eguneratu">
    </form>
</body>
</html>
