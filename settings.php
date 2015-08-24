<?php
// Connect to database
$db = new mysqli('localhost', 'root', '', '5x5');


//  Bring in the spl_loader
require_once('core/Loader.php');


// Timezone
date_default_timezone_set('Australia/Sydney');


// Start session to allow login and such
session_start();
?>