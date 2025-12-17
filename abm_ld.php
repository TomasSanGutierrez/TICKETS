<?php
include_once("libreria/motor.php");
include_once("libreria/libro_d.php");


$datos = new Libro_d();
$libro_d = new Libro_d();

include("menu_bs.php");

$operacion = '';
$id_libro = '';
$autor = '';
$titulo = '';
$edicion = '';
$anio = '';
$origen = '';
$tipo = '';
$area = '';
$materia = '';
$comentario = '';
$archivo = '';

echo '
<script>
 
function PonerNombreArchivo(){
    var x = document.getElementById("fileToUpload");
    var txt = "";
    var file = x.files[0];
                
    txt = file.name ;
           
    document.getElementById("t_file").value = txt;
}
</script>
';

if (!empty($_POST)) {

    $operacion = isset($_GET['operacion']) ? $_GET['operacion'] : 'alta' ;
	//echo $operacion;
	if ($operacion == 'alta' && !isset($_GET['id_lib'])){
	    echo '1-alta';
		$libro_d->autor=$_POST['txtAutor'];
		$libro_d->titulo=$_POST['txtTitulo'];
		$libro_d->edicion=$_POST['txtEdicion'];
		$libro_d->anio=$_POST['txtAnio'];
		$libro_d->origen=$_POST['txtOrigen'];
		$libro_d->tipo=$_POST['txtTipo'];
		$libro_d->area=$_POST['txtArea'];
		$libro_d->materia=$_POST['txtMateria'];
		$libro_d->comentario=$_POST['txtComentario'];
		$libro_d->archivo=$_POST['txtArchivo'];
		$libro_d->guardar($objConexion->enlace);
	}
	if ($operacion == 'actualizar' && isset($_GET['id_lib'])){
	    echo '2-actualizar';
		$libro_d->autor=$_POST['txtAutor'];
		$libro_d->titulo=$_POST['txtTitulo'];
		$libro_d->edicion=$_POST['txtEdicion'];
		$libro_d->anio=$_POST['txtAnio'];
		$libro_d->origen=$_POST['txtOrigen'];
		$libro_d->tipo=$_POST['txtTipo'];
		$libro_d->area=$_POST['txtArea'];
		$libro_d->materia=$_POST['txtMateria'];
		$libro_d->comentario=$_POST['txtComentario'];
		$libro_d->archivo=$_POST['txtArchivo'];
		// handle optional video update (file or url)
		$video_path = '';
		if (!empty($_FILES['video_file']) && $_FILES['video_file']['error'] == UPLOAD_ERR_OK){
		    $u = $_FILES['video_file'];
		    $ext = strtolower(pathinfo($u['name'], PATHINFO_EXTENSION));
		    $finfo = finfo_open(FILEINFO_MIME_TYPE);
		    $mime = $finfo ? finfo_file($finfo, $u['tmp_name']) : '';
		    if ($finfo) finfo_close($finfo);
		    $ok_ext = ($ext == 'mp4');
		    $ok_mime = in_array($mime, ['video/mp4','application/octet-stream']);
		    if ($ok_ext && $ok_mime){
		        if (!is_dir('libros_d_v')) @mkdir('libros_d_v',0755,true);
		        $target = 'libros_d_v/'.time()."_".preg_replace('/[^a-zA-Z0-9_\.-]/','_',basename($u['name']));
		        if (move_uploaded_file($u['tmp_name'],$target)){
		            $video_path = $target;
		        }
		    }
		}
		if (empty($video_path) && !empty($_POST['video_url'])){
		    $video_path = trim($_POST['video_url']);
		}
		if ($video_path != '') $libro_d->video = $video_path;
		
		$libro_d->actualizar($objConexion->enlace,$_GET['id_lib']);
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	if ($operacion == 'borrar' && isset($_GET['id_lib'])){
	    //echo '3-eliminar';
		$libro_d->borrar($objConexion->enlace,$_GET['id_lib']);
	}
    if ($operacion == 'edicion' && isset($_GET['id_lib'])) {
        //echo '3-edicion';
        
        $id = $_GET['id_lib'];

        $A=libro_d::traer_datos($objConexion->enlace,$id);

        $autor=$A['autor'];
		$titulo=$A['titulo'];
		$edicion=$A['edicion'];
		$anio=$A['año'];
		$origen=$A['origen'];
		$tipo=$A['tipo'];
		$area=$A['area'];
		$materia=$A['materia'];
		$comentario=$A['comentario'];
		$archivo=$A['archivo'];
		
		//$accion=$_SERVER['HTTP_REFERER'].'?operacion=actualizar&id_lib='. $id;
		//$btn_txt='Actualizar';
		//$leyenda='Modificar datos ';
    }
   
	
	
	
		
    
}


?>
<script src="bootstrap/js/funciones_d.js"></script>

<div class="container-fluid">
   <nav class="navbar navbar-default " role="navigation" >
    
      <ul class="nav navbar-nav" style="padding-top: 10px;padding-bottom: 0px;">
	  <span style="padding-right: 20px;font-weight: bold;">Publicaciones Digitales</span>
	  <?php 
		if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
		 echo '<button type="button" class="btn btn-primary  btn-sm"   onclick="cargar(\'#capa_d\',\'alta_d.php\')">Alta</button>';
	    
		}
	  ?>
       
	  </ul>      
      
      
	  
	  
      <ul class="nav navbar-nav" style="padding-top: 10px;padding-bottom: 0px;">
        <input type="text"  id="txt_b_d" placeholder="Buscar" style="position: absolute;right: 100px;" >
		<button type="button" id="btn_b_d" class="btn btn-primary btn-sm" style="position: absolute;right: 20px;">Buscar</button>
      </ul>
	 
	   
     
	 </div> 
	 
   </nav>
 </div>


<div class="row">
 
  <div class="col-sm-6">
  <div id="capa_d">
  
  </div>
  </div>
  
  <div class="col-sm-6">
  <div id="capa_L">	
  
	    </div>
</div>



</div>
</div>
</body>

</html>