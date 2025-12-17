<?php
// Use the centralized configuration file in project root
require_once __DIR__ . '/../config.php';

// Backwards compatible session name variable
$usuarios_sesion = defined('USUARIOS_SESION') ? USUARIOS_SESION : 'pwd';


