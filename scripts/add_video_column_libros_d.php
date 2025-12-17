<?php
$c = new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error){ echo 'DBERR:'.$c->connect_error; exit; }
$res = $c->query("SHOW COLUMNS FROM libros_d LIKE 'video'");
if ($res && $res->num_rows>0){
    echo "Column 'video' already exists.\n"; exit;
}
if ($c->query("ALTER TABLE libros_d ADD COLUMN video varchar(255) DEFAULT NULL")){
    echo "Column 'video' added to libros_d.\n";
} else {
    echo "Error adding column: " . $c->error . "\n";
}
?>