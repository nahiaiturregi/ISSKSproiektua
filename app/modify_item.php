<?php
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

// Editatu nahi den itemaren ID-a lortu
$item_id = $_GET['item'];

// Item honen datuak lortu bere id-a erabiliz
$query = "SELECT * FROM FunkoPop WHERE id = $item_id";
$result = mysqli_query($conn, $query);

//Kontsulta hau egin eta gero emaitzarik ez badira agertzen errore bat egon da, edo ez dago id honekin elementurik datu basean
if (!$result || mysqli_num_rows($result) == 0) {
    die("Errorea elementua aurkitzeko: " . mysqli_error($conn));
}

// Lortutako datuak array batean sartu, non gakoak zutabeen izenak diren eta datuak zutabe hauen edukia
$item = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $izena=$_POST['izena'];
    $mota=$_POST['mota'];
    $tamaina=$_POST['tamaina'];
    $prezioa=$_POST['prezioa'];

    //Datu basean erabiltzailearen datuak eguneratu
    $query="UPDATE FunkoPop SET
        izena='$izena',
        mota='$mota',
        tamaina='$tamaina',
        prezioa='$prezioa'
        WHERE id='$item_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: show_item.php?item=$item_id");
        exit();
    } else {
        echo "Errorea: " . mysqli_error($conn);
    }
}

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
    <form id="item_modify_form" action="modify_item.php?item=<?php echo $item_id; ?>" method="POST">
        Izena: <input type="text" name="izena" value="<?php echo $item['izena']; ?>" required><br>
        Mota: <input type="text" name="mota" value="<?php echo $item['mota']; ?>" required><br>
        Tamaina: <input type="text" name="tamaina" value="<?php echo $item['tamaina']; ?>" required><br>
        Prezioa: <input type="text" name="prezioa" value="<?php echo $item['prezioa']; ?>" pattern="^\d+(\.\d{1,2})?$" required><br>
        <input id="item_modify_submit" type="submit" value="Eguneratu">
    </form>
</body>
</html>