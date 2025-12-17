<?php
$c = new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error) {
    echo 'DBERR:' . $c->connect_error . "\n";
    exit;
}
// Check if column exists
$res = $c->query("SHOW COLUMNS FROM libros LIKE 'video'");
if ($res && $res->num_rows>0){
    echo "Column 'video' already exists.\n";
    exit;
}
if ($c->query("ALTER TABLE libros ADD COLUMN video varchar(255) DEFAULT NULL")){
    echo "Column 'video' added.\n";
} else {
    echo "Error adding column: " . $c->error . "\n";
}
?>