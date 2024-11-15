<?php
session_start(); // Saioa hasi sesio-aldagaiak erabiltzeko

function sortuTokenAntiCSRF() {
    if (empty($_SESSION['token_antiCSRF'])) {
        $_SESSION['token_antiCSRF'] = bin2hex(random_bytes(32)); // Token bat sortu
    }
    return $_SESSION['token_antiCSRF'];
}

function egiaztatuTokenAntiCSRF($jasotako_tokena) {
    if (isset($_SESSION['token_antiCSRF']) && hash_equals($_SESSION['token_antiCSRF'], $jasotako_tokena)) {
        return true;
    }
    return false;
}