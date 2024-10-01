<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularioa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</script>

</head>
<body>
    <h2>Ongi etorri</h2>
    <form method="post" autocomplete="off">
        <div class="input-group">

                <div class="input-container">
                    <input type="text" name ="name" placeholder="Izena">
                    <i class="fa-solid fa-user"> </i>
                </div>

                <div class="input-container">
                    <input type="text" name ="text" placeholder="NAN-a">
                    <i class="fa-solid fa-user-secret"> </i>
                </div>

                <div class="input-container">
                    <input type="date" name ="date" placeholder="Jaiotze data">
                    <i class="fa-solid fa-calendar"> </i>
                </div>

                <div class="input-container">
                    <input type="tel" name ="phone" placeholder="Telefono zenbakia">
                    <i class="fa-solid fa-phone"> </i>
                </div>

                <div class="input-container">
                    <input type="email" name ="email" placeholder="Email-a" onclick="emailbalidatu()">
                    <i class="fa-solid fa-envelope"> </i>
                </div>

                <input type="submit" name="send" class="btn" value="Bidali">
        </div>
    </form>

    <?php

        $hostname = "db";
        $username = "admin";
        $password = "test";
        $db = "database";

        $konexioa = mysqli_connect($hostname, $username, $password, $db);
        
        if(isset($_POST['send'])) {

            if(
                strlen($_POST['name']) >= 1 &&
                strlen($_POST['text']) >= 1 &&
                strlen($_POST['email']) >= 1 &&
                strlen($_POST['phone']) >= 1 &&
                strlen($_POST['date']) >= 1 
            ) {
        
                $name = trim($_POST['name']);
                $text = trim($_POST['text']);
                $email = trim($_POST['email']);
                $phone = trim($_POST['phone']);
                $date = date("y/m/d");
                $kontsulta = "INSERT INTO datuak(izena, nan, email, telefonoa, jaiotzedat)
                            VALUES('$name', '$text', '$email', '$phone', '$date')";
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
