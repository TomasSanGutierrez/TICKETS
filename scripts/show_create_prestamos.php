<?php
$c=new mysqli('localhost','root','','biblio_t1');
if($c->connect_error){echo 'DBERR'; exit;}
$res=$c->query('SHOW CREATE TABLE prestamos');
$r=$res->fetch_assoc();
echo $r['Create Table'];
?>