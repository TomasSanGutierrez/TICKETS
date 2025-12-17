<?php
$c=new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error){ echo 'DBERR'; exit; }
$q = "INSERT INTO libros (Autor,Titulo,Editorial,anio,Comentario,cantidad_total,cantidad_disponible,video) VALUES ('Test','Libro con Youtube','Ed','2025','coment',1,1,'https://youtu.be/dQw4w9WgXcQ')";
if ($c->query($q)) echo "Inserted\n"; else echo "ERR:".$c->error."\n";
?>