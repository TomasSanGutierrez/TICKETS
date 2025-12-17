<?php
$c=new mysqli('localhost','root','','biblio_t1');
if($c->connect_error){echo 'DBERR'; exit;}
$res=$c->query('SHOW COLUMNS FROM prestamos');
while($r=$res->fetch_assoc()){
    echo $r['Field'].' '.$r['Type']."\n";
}
?>