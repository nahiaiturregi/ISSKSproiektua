<?php
session_start();
<<<<<<< Updated upstream
//X-Frame-Options segurtasunerako
header("X-Frame-Options: SAMEORIGIN");
//CSP segurtasunerako
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self';");
=======

>>>>>>> Stashed changes
//Botoiren bat sakatu bada, baldintza beteko da
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    //Sakatutako botoia zein den arabera, dagokion orrira bideratu.
    switch ($action) {
        case 'erregistratu':
            header("Location: register.php");
            exit();
        case 'identifikatu':
            header("Location: login.php");
            exit();
            
        case 'zerrenda ikusi':
            header("Location: items.php");
            exit();
        
        case 'item bat gehitu':
            header("Location: add_item.php");
            exit();
    
        default:
            header("Location: index.php");
            exit();
    }
}
?>

<h1>Ongi etorri!</h1>
<p>Aukeratu zer egin nahi duzun:</p>
<form method="POST" action="index.php">
    <input type="submit" name="action" value="erregistratu" />
    <input type="submit" name="action" value="identifikatu" />
    <input type="submit" name="action" value="zerrenda ikusi" />
    <input type="submit" name="action" value="item bat gehitu" />
</form>
