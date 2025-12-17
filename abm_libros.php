<?php
include_once('libreria/motor.php');
include_once('libreria/libros.php');
include_once('libreria/persona.php');
include('menu_bs.php');

// handle actions
if ($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST['action']) && $_POST['action']=='add'){
        // handle optional video upload or URL
        $video_path = '';
        if (!empty($_FILES['video_file']) && $_FILES['video_file']['error'] == UPLOAD_ERR_OK){
            $u = $_FILES['video_file'];
            $ext = strtolower(pathinfo($u['name'], PATHINFO_EXTENSION));
            // basic validation: extension and mime type
            $ok_ext = ($ext == 'mp4');
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = $finfo ? finfo_file($finfo, $u['tmp_name']) : '';
            if ($finfo) finfo_close($finfo);
            $ok_mime = in_array($mime, ['video/mp4','application/octet-stream']);
            if ($ok_ext && $ok_mime){
                if (!is_dir('libros_v')) @mkdir('libros_v',0755,true);
                $target = 'libros_v/'.time()."_".preg_replace('/[^a-zA-Z0-9_\.-]/','_',basename($u['name']));
                if (move_uploaded_file($u['tmp_name'],$target)){
                    $video_path = $target;
                }
            }
        }
        if (empty($video_path) && !empty($_POST['video_url'])){
            $video_path = trim($_POST['video_url']);
        }

        $lib = new Libro();
        $lib->Autor = $_POST['autor'];
        $lib->Titulo = $_POST['titulo'];
        $lib->Editorial = $_POST['editorial'];
        $lib->anio = $_POST['anio'];
        $lib->Comentario = $_POST['comentario'];
        $lib->cantidad_total = intval($_POST['cantidad']);
        $lib->cantidad_disponible = intval($_POST['cantidad']);
        if ($video_path != '') $lib->video = $video_path;
        $lib->guardar($objConexion);
    }
    if (isset($_POST['action']) && $_POST['action']=='prestar'){
        $ok = Libro::prestar($objConexion,$_POST['id_libro'],$_POST['id_socio']);
    }
    if (isset($_POST['action']) && $_POST['action']=='devolver'){
        $ok = Libro::devolver($objConexion,$_POST['id_prestamo']);
    }
}

$libros = Libro::listar($objConexion);
$personas = persona::listar($objConexion);
$prestamos = Libro::prestamos_activos($objConexion);

?>

<div class="container">
 <h3>Gestión de Libros (Impresos)</h3>
 <div class="row">
  <div class="col-sm-6">
    <h4>Alta de libro</h4>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="add" />
      <div class="form-group"><label>Autor</label><input class="form-control" name="autor"></div>
      <div class="form-group"><label>Título</label><input class="form-control" name="titulo"></div>
      <div class="form-group"><label>Editorial</label><input class="form-control" name="editorial"></div>
      <div class="form-group"><label>Año</label><input class="form-control" name="anio"></div>
      <div class="form-group"><label>Cantidad</label><input class="form-control" name="cantidad" value="1"></div>
      <div class="form-group"><label>Comentario</label><textarea class="form-control" name="comentario"></textarea></div>
      <div class="form-group"><label>Video (URL o archivo .mp4)</label>
        <input class="form-control" name="video_url" placeholder="http(s)://... o YouTube URL">
        <input type="file" name="video_file" accept="video/mp4" class="form-control" style="margin-top:8px;">
        <small class="text-muted">Puedes subir un .mp4 (será alojado en <code>libros_v/</code>) o pegar una URL (YouTube o enlace directo a un .mp4).</small>
      </div>
      <button class="btn btn-primary">Guardar</button>
    </form>
  </div>
  <div class="col-sm-6">
    <h4>Libros</h4>
    <div id="capa_preview_libros" style="margin-bottom:12px;"></div>
    <table class="table table-bordered">
      <thead><tr><th>ID</th><th>Título</th><th>Autor</th><th>Disp</th><th>Preview</th></tr></thead>
      <tbody>
      <?php foreach($libros as $l){
            echo "<tr><td>$l[id_libro]</td><td>";
            if (!empty($l['video'])){
                $v = addslashes($l['video']);
                echo "<a href=\"javascript:cargar_media('#capa_preview_libros','".$v."')\">$l[Titulo]</a>";
            } else {
                echo "$l[Titulo]";
            }
            echo "</td><td>$l[Autor]</td><td>$l[cantidad_disponible]/$l[cantidad_total]</td><td>";
            if (!empty($l['video'])){
                $v = addslashes($l['video']);
                echo "<button class=\"btn btn-default btn-xs\" onclick=\"cargar_media('#capa_preview_libros','".$v."')\">Preview</button>";
            }
            echo "</td></tr>";
        } ?>
      </tbody>
    </table>
  </div>
 </div>

 <hr />
 <h4>Prestamos Activos</h4>
 <table class="table table-hover">
   <thead><tr><th>ID</th><th>Libro</th><th>Socio</th><th>Fecha</th><th>Acción</th></tr></thead>
   <tbody>
   <?php foreach($prestamos as $p){ echo "<tr><td>$p[id_prestamo]</td><td>$p[Titulo]</td><td>$p[socio]</td><td>$p[fecha_prestamo]</td><td><form style='display:inline' method='post'><input type='hidden' name='action' value='devolver'><input type='hidden' name='id_prestamo' value='$p[id_prestamo]'><button class='btn btn-success btn-xs'>Devolver</button></form></td></tr>"; } ?>
   </tbody>
 </table>

 <hr />
 <h4>Realizar prestamo</h4>
 <form method="post" class="form-inline">
   <input type="hidden" name="action" value="prestar">
   <div class="form-group"><label>Libro</label>
     <select name="id_libro" class="form-control">
       <?php foreach($libros as $l){ echo "<option value='$l[id_libro]'>$l[Titulo] ($l[cantidad_disponible])</option>";} ?>
     </select>
   </div>
   <div class="form-group"><label>Socio</label>
     <select name="id_socio" class="form-control">
       <?php foreach($personas as $pe){ echo "<option value='$pe[id]'>$pe[nombre] $pe[apellido] ($pe[user])</option>";} ?>
     </select>
   </div>
   <button class="btn btn-primary">Prestar</button>
 </form>

</div>