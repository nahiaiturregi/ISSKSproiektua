<!-- Fitxategi hau idazteko hurrengo bideoa jarraitu da: https://www.youtube.com/watch?v=VgLOIocrNq8 -->

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
    <!-- Formularioaren egitura sortu -->
    <form id="register_form" method="post" autocomplete="off" name="formularioa">
        <div class="input-group">

                <div class="input-container">
                    <input type="text" name ="name" placeholder="Izena">
                    <i class="fa-solid fa-user"> </i>
                </div>

                <div class="input-container">
                    <input type="text" name ="nan" placeholder="NAN-a">
                    <i class="fa-solid fa-user-secret"> </i>
                </div>

                <div class="input-container">
                    <input type="password" name ="password" placeholder="Pasahitza">
                    <i class="fa-solid fa-user-lock"> </i>
                </div>

                <div class="input-container">
                    <input type="jaiotze_data" name ="jaiotze_data" placeholder="Jaiotze data">
                    <i class="fa-solid fa-calendar"> </i>
                </div>

                <div class="input-container">
                    <input type="tel" name ="phone" placeholder="Telefono zenbakia">
                    <i class="fa-solid fa-phone"> </i>
                </div>

                <div class="input-container">
                    <input type="email" name ="email" placeholder="Email-a">
                    <i class="fa-solid fa-envelope"> </i>
                </div>

                <input type="submit" id="register_submit" name="send" class="btn" value="Bidali">
                <input type="button" value="Hasierara itzuli" onclick="location.href='/'">
        </div>
    </form>

    <?php
        // Datu basearekin konektatu
        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $konexioa = mysqli_connect($hostname, $username, $password, $db);
        
        // send botoia (Bidali) sakatzen bada begiratu
        if(isset($_POST['send'])) {

            // Formularioaren eremu guztietan zerbait dagoela erantzunda begiratu, bestela mezu bat agertzen da
            if(
                strlen($_POST['name']) >= 1 &&
                strlen($_POST['nan']) >= 1 &&
                strlen($_POST['email']) >= 1 &&
                strlen($_POST['phone']) >= 1 &&
                strlen($_POST['jaiotze_data']) >= 1 &&
                strlen($_POST['password']) >= 1 
            ) {
                // Erantzunen testua sinplifikatzeko, adibidez soberako espazioak kendu etab.
                $name = trim($_POST['name']);
                $nan = trim($_POST['nan']);
                $email = trim($_POST['email']);
                $phone = trim($_POST['phone']);
                $jaiotze_data = trim($_POST['jaiotze_data']);
                $password = trim($_POST['password']);
                
                // DNIak 8 zenbaki, gidoia eta letra bat duela eta letra zuzena dela konprobatu
                if (!preg_match("/^\d{8}-[A-Z]$/", $nan)) {
                    echo "DNI formatu baliogabea. 8 zenbaka, gidoia eta letra bat izan behar ditu.";
                    exit();
                }
                list($zenbakiak, $letra) = explode('-', $nan);
                $dni = (int)$zenbakiak;
                $letraIndex = $dni % 23;
                $letrak = "TRWAGMYFPDXBNJZSQVHLCKET";
                $letrakalkulatua = $letrak[$letraIndex];
                if ($letra !== $letrakalkulatua) {
                    echo "DNI letra ez da zuzena. Letra hau izango litzateke: $letrakalkulatua.";
                    exit();
                }
                
                // Data urtea, hilabetea eta egun formatuan dagoela konprobatu
                if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $jaiotze_data)) {
    			    echo "Data formatu baliogabea(uuuu-hh-ee).";
  			        exit();	
		        }

                // Telefono zenbakiak 9 digitu duela egiaztatu
                if (!preg_match("/^\d{9}$/", $phone)) {
                    echo "Telefono zenbaki baliogabea";
                   exit();
                }

                // Email-ak [testua + @ + testua + . + testua] formatua duela konprobatu
                if (!preg_match("/^.+@.+\..+$/", $email)) {
                    echo "Posta elektroniko baliogabea";
                    exit();
                }
                
                // Datu basean formularioko erantzunak sartu 
                $kontsulta = "INSERT INTO usuarios(nombre, nan, email, telefonoa, jaiotze_data, pasahitza)
                            VALUES('$name', '$nan', '$email', '$phone', '$jaiotze_data', '$password')";
                $emaitza = mysqli_query($konexioa, $kontsulta);
                // Emaitza bat badago kontsultari erabiltzailea erregistratzen da, bestela errore ematen du
                if($emaitza) {
                    ?>
                        <h3 class="success">Zure erabiltzailea sisteman erregistratu da</h3>
                    <?php
                } else {
                    ?>
                        <h3 class="error">Errore bat egon da</h3>
                    <?php
                }
            } else {
                ?>
                    <h3 class="error">Eremu guztiak bete</h3>
                <?php
            }
        
        }
    ?>

</body>
</html>