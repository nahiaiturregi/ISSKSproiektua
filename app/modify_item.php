<?php
//X-Frame-Options segurtasunerako
header("X-Frame-Options: SAMEORIGIN");
//CSP segurtasunerako
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
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
        echo "ID ez da onargarria.";
        exit();
    }

// Item honen datuak lortu bere id-a erabiliz
$stmt = $conn->prepare("SELECT * FROM FunkoPop WHERE id = ?");
$stmt->bind_param("i",$item_id);
$stmt->execute();
$result = $stmt->get_result();

//Kontsulta hau egin eta gero emaitzarik ez badira agertzen errore bat egon da, edo ez dago id honekin elementurik datu basean
if (!$result || mysqli_num_rows($result) == 0) {
    die("Errorea elementua aurkitzeko: " . mysqli_error($conn));
}

// Lortutako datuak array batean sartu, non gakoak zutabeen izenak diren eta datuak zutabe hauen edukia
$item = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $S_POST = sanitize_array($_POST);
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
        echo "Errorea: " . $stmt->error;
    }
}

$stmt->close();
mysqli_close($conn);
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
        <input id="item_modify_submit" type="submit" value="Eguneratu">
    </form>
</body>
</html>
