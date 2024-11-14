<?php
    session_start(); //Saioa hasi beharrezko informazioa gordetzeko
    //X-Frame-Options segurtasunerako
    header("X-Frame-Options: SAMEORIGIN");
    //CSP segurtasunerako
    header("Content-Security-Policy: style-src 'self'; img-src 'self';");
    //DB-arekin konexioa sortu
    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname, $username, $password, $db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    function sortuTokenAntiCSRF() {
        if (empty($_SESSION['token_antiCSRF'])) {
            $_SESSION['token_antiCSRF'] = bin2hex(random_bytes(32)); //Token bat sortu
        }
        return $_SESSION['token_antiCSRF'];
    }

    function egiaztatuTokenAntiCSRF($jasotako_tokena) {
        if (isset($_SESSION['token_antiCSRF']) && hash_equals($_SESSION['token_antiCSRF'], $jasotako_tokena)) {
            return true;
        }
        return false;
    }

    $token_antiCSRF = sortuTokenAntiCSRF();

    //Erabiltzailea eta pasahitza bidaltzen badira, datu basean dauden datuekin konparatuko dira
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $jasotako_tokena = $_POST['token_antiCSRF'] ?? '';
        if (!egiaztatuTokenAntiCSRF($jasotako_tokena)) {
            echo "Ezin da sarbidea onartu.";
            exit();
        }

        $erabiltzailea = $_POST['erabiltzailea'];
        $pasahitza = $_POST['pasahitza'];

        //Kontsulta erabiltzailearen hash-a lortzeko
        $stmt = $conn->prepare("SELECT id, pasahitza FROM usuarios WHERE nombre= ?");
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
                header("Location: show_user.php?user=$id");
                exit();
            }else{
                echo "Erabiltzaile edo pasahitza okerra.";
            }
        } else {
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
</head>
<body>
    <form name="login_form" id="login_form" method="POST" action="">
        <label>Erabiltzailea:</label><br>
        <input type="text" name="erabiltzailea"><br>
        <label>Pasahitza:</label><br>
        <input type="password" name="pasahitza"><br>
        <input type="button" name="login_submit" id="login_submit" value="bidali" onclick="datuakEgiaztatu()">
        <input type="button" value="Hasierara itzuli" onclick="location.href='/'">
        <input type="hidden" name="token_antiCSRF" value="<?php echo htmlspecialchars($token_antiCSRF); ?>">
    </form>
    <script>
        //Datuak hutsik bidaltzen ez direla egiaztatzeko
        function datuakEgiaztatu() {
            var erabiltzailea = document.login_form.erabiltzailea.value;
            var pasahitza = document.login_form.pasahitza.value;
            if (erabiltzailea == "" || pasahitza == "") {
                window.alert("Erabiltzailea edo pasahitza hutsik dago");
            } else {
                document.login_form.submit();
            }
        }
    </script>
</body>
</html>
