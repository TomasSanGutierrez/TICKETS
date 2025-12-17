<?php
$c=new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error){ echo 'DBERR'; exit; }
$q = "INSERT INTO libros_d (Autor,Titulo,edicion,año,origen,Area,Materia,Comentario,Archivo,tipo,video) VALUES ('Test','Video Libro','1st','2025','Origen','Area','Mat','coment','', 'Video','https://youtu.be/dQw4w9WgXcQ')";
if ($c->query($q)) echo "Inserted libros_d video\n"; else echo "ERR:".$c->error."\n";
?>