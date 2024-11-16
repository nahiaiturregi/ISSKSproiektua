<?php
session_start(); // Saioa hasi sesio-aldagaiak erabiltzeko

function checkAdmin() {
    if ($_SESSION['rol'] !== 1) {
        header("Location: no_permission.php");
        exit();
    }
}
