<?php
session_start();

function checkAdmin() {
    if ($_SESSION['rol'] !== 1) {
        echo "Ez duzu baimenik hori egiteko.";
        exit();
    }
}