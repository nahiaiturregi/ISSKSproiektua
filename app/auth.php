<?php
session_start(); // Saioa hasi sesio-aldagaiak erabiltzeko

function checkAdmin() {
    if ($_SESSION['rol'] !== 1) {
        echo "Ez duzu baimenik hori egiteko.";
        exit();
    }
}