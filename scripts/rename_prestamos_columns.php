<?php
// Rename prestamos columns to original names: id -> id_prestamo, libro_id -> id_libro, usuario_id -> id_socio
$c = new mysqli('localhost','root','','biblio_t1');
if ($c->connect_error){ echo 'DBERR:'.$c->connect_error; exit; }
$res = $c->query("SHOW COLUMNS FROM prestamos LIKE 'id_prestamo'");
if ($res && $res->num_rows>0){
    echo "Columns already renamed (id_prestamo exists).\n"; exit;
}
// Start transaction
$c->begin_transaction();
try {
    // Rename id -> id_prestamo and set AUTO_INCREMENT and PRIMARY KEY
    if ($c->query("ALTER TABLE prestamos CHANGE `id` `id_prestamo` INT(11) NOT NULL AUTO_INCREMENT" ) === FALSE) throw new Exception($c->error);
    // Rename libro_id -> id_libro
    if ($c->query("ALTER TABLE prestamos CHANGE `libro_id` `id_libro` INT(11) NOT NULL" ) === FALSE) throw new Exception($c->error);
    // Rename usuario_id -> id_socio
    if ($c->query("ALTER TABLE prestamos CHANGE `usuario_id` `id_socio` INT(11) NOT NULL" ) === FALSE) throw new Exception($c->error);
    // Add estado column if missing (original code used estado default 'pendiente')
    $res2 = $c->query("SHOW COLUMNS FROM prestamos LIKE 'estado'");
    if (!($res2 && $res2->num_rows>0)){
        if ($c->query("ALTER TABLE prestamos ADD COLUMN estado varchar(20) NOT NULL DEFAULT 'pendiente'" ) === FALSE) throw new Exception($c->error);
        // For existing rows that have fecha_devolucion NULL set estado='pendiente' and others 'devuelto'
        $c->query("UPDATE prestamos SET estado = IF(fecha_devolucion IS NULL,'pendiente','devuelto')");
    }
    // Ensure primary key exists on id_prestamo
    $c->query("ALTER TABLE prestamos DROP PRIMARY KEY");
    $c->query("ALTER TABLE prestamos ADD PRIMARY KEY (id_prestamo)");

    $c->commit();
    echo "Renamed prestamos columns to id_prestamo, id_libro, id_socio and ensured estado column.\n";
} catch (Exception $e){
    $c->rollback();
    echo "Error renaming columns: ".$e->getMessage()."\n";
}
?>