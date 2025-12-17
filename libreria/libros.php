<?php
include_once('motor.php');

class Libro{
    public $id_libro;
    public $Autor;
    public $Titulo;
    public $Editorial;
    public $anio;
    public $Comentario;
    public $cantidad_total;
    public $cantidad_disponible;
    public $video; // url or local path to video file

    function guardar($objConexion){
        $video_sql = isset($this->video) && $this->video != '' ? "'" . mysqli_real_escape_string($objConexion->enlace, $this->video) . "'" : "NULL";
        $sql = "INSERT INTO libros (Autor, Titulo, Editorial, anio, Comentario, cantidad_total, cantidad_disponible, video) VALUES ('".mysqli_real_escape_string($objConexion->enlace,$this->Autor)."','".mysqli_real_escape_string($objConexion->enlace,$this->Titulo)."','".mysqli_real_escape_string($objConexion->enlace,$this->Editorial)."','".mysqli_real_escape_string($objConexion->enlace,$this->anio)."','".mysqli_real_escape_string($objConexion->enlace,$this->Comentario)."',".intval($this->cantidad_total).",".intval($this->cantidad_disponible).",".$video_sql.")";
        mysqli_query($objConexion->enlace,$sql);
    }

    static function listar($objConexion){
        $sql = "SELECT * FROM libros";
        $rs = mysqli_query($objConexion->enlace,$sql);
        $r = [];
        while($f = mysqli_fetch_assoc($rs)) $r[] = $f;
        return $r;
    }

    static function traer($objConexion,$id){
        $sql = "SELECT * FROM libros WHERE id_libro=".intval($id);
        $rs = mysqli_query($objConexion->enlace,$sql);
        return mysqli_fetch_assoc($rs);
    }

    static function prestar($objConexion,$id_libro,$id_socio){
        // check disponibilidad
        $lib = self::traer($objConexion,$id_libro);
        if (!$lib || $lib['cantidad_disponible']<1) return false;
        $sql = "INSERT INTO prestamos (id_libro,id_socio,fecha_prestamo,estado) VALUES (".intval($id_libro).",".intval($id_socio).",CURDATE(),'pendiente')";
        if (mysqli_query($objConexion->enlace,$sql)){
            $sql2 = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id_libro=".intval($id_libro);
            mysqli_query($objConexion->enlace,$sql2);
            return true;
        }
        return false;
    }

    static function devolver($objConexion,$id_prestamo){
        $sql = "SELECT id_libro FROM prestamos WHERE id_prestamo=".intval($id_prestamo).
               " AND estado='pendiente'";
        $rs = mysqli_query($objConexion->enlace,$sql);
        if ($fila = mysqli_fetch_assoc($rs)){
            $id_libro = $fila['id_libro'];
            $sql2 = "UPDATE prestamos SET fecha_devolucion = CURDATE(), estado='devuelto' WHERE id_prestamo=".intval($id_prestamo);
            mysqli_query($objConexion->enlace,$sql2);
            $sql3 = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id_libro=".intval($id_libro);
            mysqli_query($objConexion->enlace,$sql3);
            return true;
        }
        return false;
    }

    static function prestamos_activos($objConexion){
        $sql = "SELECT p.*, l.Titulo, concat(pe.nombre,' ',pe.apellido) as socio FROM prestamos p JOIN libros l ON p.id_libro=l.id_libro JOIN personas pe ON p.id_socio=pe.id WHERE p.estado='pendiente'";
        $rs = mysqli_query($objConexion->enlace,$sql);
        $r=[]; while($f=mysqli_fetch_assoc($rs)) $r[]=$f; return $r;
    }
}
?>