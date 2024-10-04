<?php
session_start();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
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
       	case 'erabiltzailearen datuak aldatu':
       	    header("Location: modify_user.php");
       	    exit();
       	    
        default:
            // Si la acción no es válida, redirigir al home
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
    <input type="submit" name="action" value="erabiltzailearen datuak aldatu" />
</form>
