<?php
	//X-Frame-Options segurtasunerako
	header("X-Frame-Options: SAMEORIGIN");
	//CSP segurtasunerako
	header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $konexioa = mysqli_connect($hostname, $username, $password, $db);
        if($konexioa->connect_error) {
            die("Datu basearekin konexioa ezin izan da egin: " . $konexioa->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $nan = $_POST['nan'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $jaiotze_data = $_POST['jaiotze_data'];
            $password = $_POST['password'];

            //Pasahitza hasheatu Argon2 algoritmoarekin
            $hashed_password = password_hash($password, PASSWORD_ARGON2I);

            $stmt = $konexioa->prepare("INSERT INTO usuarios(nombre, nan, email, telefonoa, jaiotze_data, pasahitza) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param("sssiss", $name, $nan, $email, $phone, $jaiotze_data, $hashed_password);
            if($stmt->execute()) {
                echo "<h3 class='success'>Zure erabiltzailea sisteman erregistratu da</h3>";
            } else {
                echo "<h3 class='error'>Errore bat egon da</h3>";
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularioa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/register.js" defer></script>
</head>
<body>
    <h2>Ongi etorri</h2>
    <form id="register_form" method="POST" autocomplete="off" name="register_form">
        <div class="input-group">
            <div class="input-container">
                <input type="text" name="name" placeholder="Izen abizenak">
                <i class="fa-solid fa-user"> </i>
            </div>

            <div class="input-container">
                <input type="text" name="nan" placeholder="NAN-a (12345678-Z)">
                <i class="fa-solid fa-user-secret"> </i>
            </div>

            <div class="input-container">
                <input type="password" name="password" placeholder="Pasahitza">
                <i class="fa-solid fa-user-lock"> </i>
            </div>

            <div class="input-container">
                <input type="text" name="jaiotze_data" placeholder="Jaiotze data (uuuu-hh-ee)">
                <i class="fa-solid fa-calendar"> </i>
            </div>

            <div class="input-container">
                <input type="tel" name="phone" placeholder="Telefonoa (123456789)">
                <i class="fa-solid fa-phone"> </i>
            </div>

            <div class="input-container">
                <input type="email" name="email" placeholder="Email (adibidea@zerb.ext)">
                <i class="fa-solid fa-envelope"> </i>
            </div>


            <input type="button" name="register_submit" id="register_submit" value="bidali">
            <input type="button" value="Hasierara itzuli" id="reset_button">
            <input type="hidden" name="bidalita" value="0">
        </div>
    </form>
</body>
</html>
