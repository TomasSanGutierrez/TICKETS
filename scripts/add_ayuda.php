<?php
require_once __DIR__ . '/../config.php';

$conn = db_connect();
$sql = "INSERT INTO carteles (categoria, titulo, texto, imagen, plantilla, v_desde, v_hasta, activo, link, texto1, texto2, imagen1) VALUES ('Ayuda', 'Cómo usar la Biblioteca', 'En esta sección encontrará respuestas a preguntas frecuentes y guías para usar el sistema de la biblioteca.', '', 5, '', '', 1, '', '', '', '')";
if (mysqli_query($conn, $sql)) {
    echo "OK: inserted id=".mysqli_insert_id($conn);
} else {
    echo "Error: ".mysqli_error($conn);
}
mysqli_close($conn);
?>