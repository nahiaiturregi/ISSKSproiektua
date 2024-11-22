<?php
include('session_config.php');

$max_inactivity_time = 120;

if (isset($_SESSION['last_activity'])) {
    $inactivity_duration = time() - $_SESSION['last_activity'];
    if ($inactivity_duration > $max_inactivity_time) {
        session_unset();
        session_destroy();
		header("Location: login.php?timeout=1"); 
        exit();
    }
}

$_SESSION['last_activity'] = time(); // Actualizar la última actividad