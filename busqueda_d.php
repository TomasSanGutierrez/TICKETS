<?php
include("libreria/motor.php");
include_once("libreria/libro_d.php");
session_start();
$str_b =  $_POST['b'];
//echo $str_b;
//$lib=Libro_d::buscar($str_b);
$lib=Libro_d::buscar($objConexion->enlace,$str_b);

?>
<?php
if (isset($lib)){
?>
<div class="panel panel-default" >
 
  <div class="panel-heading">Publicaciones Encontradas</div> 
	 <div style="overflow: scroll;height: 350px;">  
	  <table class="tabla_edicion table table-hover">
	  <thead>
			  <tr>
			  <th>Titulo</th>
			  <th>Autor</th>
			  <th>Tipo</th>
		  <th>Video/Preview</th>
			  
			  
			  </tr>
		  </thead>
	  <tbody>
	  <?php
		  foreach($lib as $libros){
		   echo "<tr><td>";
		   if (!empty($libros['Archivo'])) {
               echo "<a href=\"javascript:cargar_media('#capa_d','" . addslashes('libros_d/'.$libros['Archivo']) . "')\">".$libros['Titulo']."</a>";
           } elseif (!empty($libros['video'])) {
               echo "<a href=\"javascript:cargar_media('#capa_d','" . addslashes($libros['video']) . "')\">".$libros['Titulo']."</a>";
           } else {
               echo $libros['Titulo'];
           }
           echo "</td><td>".$libros['Autor']."</td><td>".$libros['tipo']."</td>";
         
         $file_l=$libros['Archivo'] ;
         if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
         echo '<td><button class="btn btn-primary btn-xs" onclick="editar(' . $libros['id_libro'] . ')" >Editar</button></td>';
         echo '<td><button class="btn btn-primary btn-xs" onclick="borrar(' . $libros['id_libro'] . ')" >Borrar</button></td>';
         }
         else{
         echo '<td><button class="btn btn-primary btn-xs" onclick="ver_info(' . $libros['id_libro'] . ')" >Info</button></td>';
         }
         echo '<td>';
         if (!empty($libros['video'])){
            $v = addslashes($libros['video']);
            echo '<button class="btn btn-default btn-xs" onclick="cargar_media(\'#capa_d\',\''.$v.'\')">Video</button>';
         }
         if (!empty($file_l)){
            $f = addslashes('libros_d/'.$file_l);
            echo ' <button class="btn btn-primary btn-xs" onclick="cargar_media(\'#capa_d\',\'' . $f . '\')">Documento</button>';
         }
         echo '</td>';
         
         echo " </tr> ";
           }
	  ?>
	  </tbody>
	  </table>
	  </div>
	  </div></div>
	  
<?php
}
?>