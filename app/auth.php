<?php
include('session_config.php');

function checkAdmin() {
    if ($_SESSION['rol'] !== 1) {
        echo "Ez duzu orri honetara sartzeko baimenik.";
        exit();
    }
}
