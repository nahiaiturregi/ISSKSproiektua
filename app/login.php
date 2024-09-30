<?php
    session_start();

    $hostname = "db";
    $username = "admin";
    $password = "test";
    $db = "database";

    $conn = mysqli_connect($hostname, $username, $password, $db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['bidalita']) && $_POST['bidalita'] == '1') {
        $erabiltzailea = $_POST['erabiltzailea'];
        $pasahitza = $_POST['pasahitza'];

        //$erabiltzailea = mysqli_real_escape_string($conn, $erabiltzailea);
        //$pasahitza = mysqli_real_escape_string($conn, $pasahitza);

        $query = "SELECT * FROM usuarios WHERE nombre='$erabiltzailea' AND telefonoa='$pasahitza'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['erabiltzailea'] = $erabiltzailea;
            echo "Login successful!";
            //Redirigir
        } else {
            echo "Invalid erabiltzailea or pasahitza.";
        }
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
        <input type="hidden" name="bidalita" value="0">
    </form>
    <script>
        function datuakEgiaztatu() {
            var erabiltzailea = document.login_form.erabiltzailea.value;
            var pasahitza = document.login_form.pasahitza.value;
            if (erabiltzailea == "" || pasahitza == "") {
                window.alert("Erabiltzailea edo pasahitza hutsik dago");
            } else {
                document.login_form.bidalita.value = '1';
                document.login_form.submit();
            }
        }
    </script>
</body>
</html>
