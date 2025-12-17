<?php
$c=new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error){ echo 'DBERR'; exit; }
$q = "INSERT INTO libros (Autor,Titulo,Editorial,anio,Comentario,cantidad_total,cantidad_disponible,video) VALUES ('Test','Libro con MP4','Ed','2025','coment',1,1,'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4')";
if ($c->query($q)) echo "Inserted mp4\n"; else echo "ERR:".$c->error."\n";
?>