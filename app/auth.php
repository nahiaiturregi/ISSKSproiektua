<?php
include('session_config.php');

function checkAdmin() {
    if ($_SESSION['rol'] !== 1) {
        header("Location: no_permission.php");
        exit();
    }
}
