<?php
$c = new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error){ echo 'DBERR:'.$c->connect_error; exit; }
$res = $c->query("SHOW COLUMNS FROM libros_d LIKE 'video_poster'");
if ($res && $res->num_rows>0){
    echo "Column 'video_poster' already exists in libros_d.\n"; exit;
}
if ($c->query("ALTER TABLE libros_d ADD COLUMN video_poster varchar(255) DEFAULT NULL")){
    echo "Column 'video_poster' added to libros_d.\n";
} else {
    echo "Error adding column: " . $c->error . "\n";
}
?>