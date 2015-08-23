<?php
// Connect to database
$db = new mysqli('localhost', 'root', '', '5x5');

$view_path = 'app/views/';

//  Bring in the spl_loader
require_once('core/Loader.php');

// Timezone
$timezone = 'Australia/Sydney';

date_default_timezone_set($timezone);

// Start session to allow login and such
session_start();
?>