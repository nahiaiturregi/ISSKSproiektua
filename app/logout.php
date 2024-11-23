<?php
include('session_config.php');
include_once('config.php'); 

session_unset();
session_destroy();
header("Location: index.php");
exit();