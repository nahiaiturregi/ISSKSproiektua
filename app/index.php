<?php
session_start(); // Start the session

// Check if an action has been selected
if (isset($_POST['action'])) {
    $_SESSION['selected_action'] = $_POST['action']; // Save the selected action
}

// Determine which form to show based on user selection
switch ($_SESSION['selected_action'] ?? null) {
    case 'identifikatu':
        include 'login.php'; // Show Formulario de Registro
        break;

    case 'zerrenda ikusi':
        include 'items.php'; // Show the items list
        break;

    default:
        // Show the menu if no action has been selected
        ?>
        <h1>Seleccione una acción</h1>
        <form method="POST">
            <input type="submit" name="action" value="identifikatu" />
            <input type="submit" name="action" value="zerrenda ikusi" />
        </form>
        <?php
        break;
}
?>

