<?php
// Connect to database
$db = new mysqli('localhost', 'root', '', '5x5');

$view_path = 'application/views/';

//  Bring in the spl_loader
require_once('core/Loader.php');

// Start session to allow login and such
session_start();
?>