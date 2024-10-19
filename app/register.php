<?php
        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $konexioa = mysqli_connect($hostname, $username, $password, $db);
        if($konexioa->connect_error) {
            die("Datu basearekin konexioa ezin izan da egin: " . $konexioa->connect_error);
        }

        if (isset($_POST['bidalita']) && $_POST['bidalita'] == '1') {
            $name = $_POST['name'];
            $nan = $_POST['nan'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $jaiotze_data = $_POST['jaiotze_data'];
            $password = $_POST['password'];

            $kontsulta = "INSERT INTO usuarios(nombre, nan, email, telefonoa, jaiotze_data, pasahitza) VALUES('$name', '$nan', '$email', '$phone', '$jaiotze_data', '$password')";
            $emaitza = mysqli_query($konexioa, $kontsulta);
            if($emaitza) {
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

            <input type="button" name="register_submit" id="register_submit" value="bidali" onclick="datuakEgiaztatu()">
            <input type="button" value="Hasierara itzuli" onclick="location.href='/'">
            <input type="hidden" name="bidalita" value="0">
        </div>
    </form>
    <script>
        //Datuen formatua egiaztatzeko eta eremuak hutsik ez daudela egiaztatzeko funtzioa
        function datuakEgiaztatu() {
            const form = document.forms["register_form"];
            const name = form["name"].value.trim();
            const nan = form["nan"].value.trim();
            const email = form["email"].value.trim();
            const phone = form["phone"].value.trim();
            const jaiotze_data = form["jaiotze_data"].value.trim();
            const password = form["password"].value.trim();

            if (name === "" || nan === "" || email === "" || phone === "" || jaiotze_data === "" || password === "") {
                alert("Eremu guztiak bete behar dira.");
                return false;
            }

            const nanRegex = /^\d{8}-[A-Z]$/;
            if (!nanRegex.test(nan)) {
                alert("DNI formatu baliogabea. 8 zenbaki, gidoia eta letra bat izan behar ditu.");
                return false;
            }
            const [zenbakiak, letra] = nan.split('-');
            const dni = parseInt(zenbakiak, 10);
            const letraIndex = dni % 23;
            const letrak = "TRWAGMYFPDXBNJZSQVHLCKET";
            const letrakalkulatua = letrak[letraIndex];
            if (letra !== letrakalkulatua) {
                alert(`DNI letra ez da zuzena.`);
                return false;
            }

            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(jaiotze_data)) {
                alert("Data formatu baliogabea(uuuu-hh-ee).");
                return false;
            }

            const phoneRegex = /^\d{9}$/;
            if (!phoneRegex.test(phone)) {
                alert("Telefono zenbaki baliogabea");
                return false;
            }

            const emailRegex = /^.+@.+\..+$/;
            if (!emailRegex.test(email)) {
                alert("Posta elektroniko baliogabea");
                return false;
            }

            document.register_form.bidalita.value = '1';
            document.register_form.submit();
            return true;
        }
    </script>
</body>
</html>