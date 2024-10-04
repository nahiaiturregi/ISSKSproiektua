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
    <form method="post" autocomplete="off" name="formularioa">
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

                <input type="submit" name="send" class="btn" value="Bidali">
        </div>
    </form>
    <script>
        function NANbalidatu() {
            
        }
    </script>

    <?php

        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $konexioa = mysqli_connect($hostname, $username, $password, $db);
        
        if(isset($_POST['send'])) {

            if(
                strlen($_POST['name']) >= 1 &&
                strlen($_POST['nan']) >= 1 &&
                strlen($_POST['email']) >= 1 &&
                strlen($_POST['phone']) >= 1 &&
                strlen($_POST['jaiotze_data']) >= 1 &&
                strlen($_POST['password']) >= 1 
            ) {
        
                $name = trim($_POST['name']);
                $text = trim($_POST['nan']);
                $email = trim($_POST['email']);
                $phone = trim($_POST['phone']);
                $jaiotze_data = trim($_POST['jaiotze_data']);
                $password = trim($_POST['password']);
                
                if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $jaiotze_data)) {
    			echo "Data formatu baliogabea(uuuu-hh-ee).";
  			exit();	
		}

                $kontsulta = "INSERT INTO usuarios(id,nombre, nan, email, telefonoa, jaiotze_data, pasahitza)
                            VALUES(2,'$name', '$text', '$email', '$phone', '$jaiotze_data', '$password')";
                $emaitza = mysqli_query($konexioa, $kontsulta);
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