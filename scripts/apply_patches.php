<?php
require_once __DIR__ . '/../config.php';
$files = [ __DIR__ . '/../sql/patch_libros_prestamos.sql', __DIR__ . '/../sql/patch_add_ayuda.sql' ];
$conn = db_connect();
foreach($files as $file){
    echo "Applying: $file\n";
    if (!file_exists($file)){
        echo "  File not found: $file\n";
        continue;
    }
    $sql = file_get_contents($file);
    if (!$sql){
        echo "  Could not read file: $file\n";
        continue;
    }
    // Split on statements and execute safely
    if (mysqli_multi_query($conn, $sql)){
        do {
            if ($res = mysqli_store_result($conn)){
                mysqli_free_result($conn);
            }
        } while (mysqli_more_results($conn) && mysqli_next_result($conn));
        echo "  OK\n";
    } else {
        echo "  Error: " . mysqli_error($conn) . "\n";
    }
}
mysqli_close($conn);
echo "Done.\n";
?>