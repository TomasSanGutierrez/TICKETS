<?php
// Central configuration for DB and app
// Database connection constants
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','biblio_t1');

// Session name
define('USUARIOS_SESION', 'pwd');

// Helper to get a mysqli connection
function db_connect(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die('Connection error: '.mysqli_connect_error());
    }
    return $conn;
}

?>