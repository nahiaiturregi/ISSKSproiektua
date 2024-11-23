<?php
    require 'anti_CSRF.php';
    require 'log_idatzi.php';
    require 'sanitize.php';
    
    include('session_config.php');

    $token_antiCSRF = sortuTokenAntiCSRF(); //CSRF erasoen kontra token bat sortu edo lortu
 
    //DB-arekin konexioa sortu
    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";
    
    $action = "login";

    $conn = mysqli_connect($hostname, $username, $password, $db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    //Erabiltzailea eta pasahitza bidaltzen badira, datu basean dauden datuekin konparatuko dira
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $S_POST = sanitize_array($_POST);
        $jasotako_tokena = $S_POST['token_antiCSRF'] ?? '';
        if (!egiaztatuTokenAntiCSRF($jasotako_tokena)) {
            logAction($action,$S_POST,"FAILED: Token anti-CSRF ez baliozkoa");
            echo "Ezin da sarbidea onartu.";
            exit();
        }
        $erabiltzailea = $S_POST['erabiltzailea'];
        $pasahitza = $S_POST['pasahitza'];

        //Kontsulta erabiltzailearen hash-a lortzeko
        $stmt = $conn->prepare("SELECT id, pasahitza, rol FROM usuarios WHERE nombre= ?");
        $stmt->bind_param("s", $erabiltzailea); 
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $stored_hash = $row['pasahitza'];
            $id = $row['id'];

            //Pasahitza konprobatu
            if(password_verify($pasahitza, $stored_hash)){
                $_SESSION['user'] = $id;
                $_SESSION['rol'] = $row['rol']; //Erabiltzailearen rola gorde
                logAction($action,$S_POST,"OK");
                header("Location: show_user.php?user=$id");
                exit();
            }else{
                logAction($action,$S_POST,"FAILED: Pasahitz okerra");
                echo "Erabiltzaile edo pasahitza okerra.";
            }
        } else {
            logAction($action,$S_POST,"FAILED: Ez da erabiltzailea aurkitu");
            echo "Erabiltzaile edo pasahitza okerra.";
        }
        $stmt->close();
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Identifikatu</title>
    <script src="js/login.js" defer></script>
</head>
<body>
    <?php
    if (isset($_GET['timeout']) && $_GET['timeout'] == '1') {
        echo "<p style='color: red;'>Sesioa iraungi da, berriro saioa hasi.</p>";
    }
    ?>
    <form name="login_form" id="login_form" method="POST" action="">
        <label>Erabiltzailea:</label><br>
        <input type="text" name="erabiltzailea"><br>
        <label>Pasahitza:</label><br>
        <input type="password" name="pasahitza"><br>
        <input type="button" name="login_submit" id="login_submit" value="bidali">
        <input type="button" value="Hasierara itzuli" id="reset_button">
        <input type="hidden" name="token_antiCSRF" value="<?php echo htmlspecialchars($token_antiCSRF); ?>">
    </form>
</body>
</html>
