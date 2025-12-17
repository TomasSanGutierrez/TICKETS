<?php
class Libro_d{
 public $id;
 public $id_libro;
 public $autor;
 public $titulo;
 public $edicion;
 public $anio;
 public $origen;
 public $tipo;
 public $area;
 public $materia;
 public $comentario;
 public $archivo;
 public $video; // url or local path to video file
 
//ESTE CODIGO FUE MIGRADO DESDE LA EXTENSION ANTIGUA MYSQL A LA NUEVA MYSQLi
//UTILIZANDO LA INTERFAZ PRCEDIMENTAL (http://php.net/manual/es/mysqli.quickstart.dual-interface.php)
 
 //function guardar(){
 function guardar($objConexion){
   $video_sql = isset($this->video) && $this->video != '' ? "'".mysqli_real_escape_string($objConexion, $this->video)."'" : "NULL";
   $sql="insert into libros_d(autor,titulo,edicion,año,origen,tipo,area,materia,comentario,archivo,video) values('$this->autor','$this->titulo','$this->edicion','$this->anio','$this->origen','$this->tipo','$this->area','$this->materia','$this->comentario','$this->archivo,".$video_sql.")";
   //mysql_query($sql);
   mysqli_query($objConexion,$sql);
 }
 
 function actualizar($objConexion,$nro=0)	// actualiza el estudiante cargado en los atributos
	{
		$video_sql = isset($this->video) && $this->video != '' ? "video='".mysqli_real_escape_string($objConexion,$this->video)."'," : '';
		$sql = "update libros_d set 
				Autor='".mysqli_real_escape_string($objConexion,$this->autor)."',
				Titulo='".mysqli_real_escape_string($objConexion,$this->titulo)."',
				año='".mysqli_real_escape_string($objConexion,$this->anio)."',
				origen='".mysqli_real_escape_string($objConexion,$this->origen)."',
				tipo='".mysqli_real_escape_string($objConexion,$this->tipo)."',
				Area='".mysqli_real_escape_string($objConexion,$this->area)."',
				Materia='".mysqli_real_escape_string($objConexion,$this->materia)."',
				Comentario='".mysqli_real_escape_string($objConexion,$this->comentario)."',
				Archivo='".mysqli_real_escape_string($objConexion,$this->archivo)."',
				".$video_sql."where id_libro = " . intval($nro);
			//mysql_query($sql); // ejecuta la consulta para actualizar 
			mysqli_query($objConexion,$sql);
	}
	
 function borrar($objConexion,$nro=0)	// elimina el estudiante
	{
			$sql="delete from libros_d where id_libro=$nro";
			mysqli_query($objConexion,$sql); // ejecuta la consulta para eliminar
	
	}	

//function traer_datos($nro=0)	
function traer_datos($objConexion,$nro=0) // declara el constructor, si trae el numero de estudiante lo busca 
	{
		if ($nro!=0)
		{
			$sql="select * from libros_d where id_libro = $nro";
			//$result=mysql_query($sql);
			$result=mysqli_query($objConexion,$sql);
			$recs=mysqli_num_rows($result);
			$row=mysqli_fetch_array($result);
			$id=$row['id_libro'];
			
			return $row;
		}
	}	
 
 static function mostrar_todos($objConexion){
    $sql="select * from libros_d";
    $rs=mysqli_query($objConexion,$sql);
	$lib=array();
	
	while($fila=mysqli_fetch_assoc($rs)){
	  $lib[]=$fila;
	}return $lib;
 
 }
 
 static function buscar($objConexion,$str){
    $sql="select * from libros_d where autor like '%$str%' or titulo like '%$str%' or tipo like '%$str%' or Area like '%$str%' or Materia like '%$str%' or id_libro='$str' order by titulo";
    //$rs=mysql_query($sql);
	$rs=mysqli_query($objConexion,$sql);
	$lib=array();
	
	//while($fila=mysql_fetch_assoc($rs)){
	while($fila=mysqli_fetch_assoc($rs)){
	  $lib[]=$fila;
	}return $lib;
 
 }
 
 static function buscar_tit($objConexion,$str,$tipo){
    
    if($tipo=='origen'){
    $sql="SELECT DISTINCT origen FROM libros_d WHERE origen LIKE '".$str."%' ORDER BY origen ASC";
	$resultado=mysqli_query($objConexion,$sql);
	
	
    $data = array();
    while ($fila=mysqli_fetch_assoc($resultado)) {
	    array_push($data, $fila['origen']);	
       
    }
    }
	/*
	if($tipo=='area'){
    $sql="SELECT DISTINCT area FROM libros_d WHERE area LIKE '".$str."%' ORDER BY area ASC";
	$resultado=mysql_query($sql);
	$data = array();
    while ($fila=mysql_fetch_assoc($resultado)) {
	    array_push($data, $fila['area']);	
       
    }
    }
	
	if($tipo=='materia'){
    $sql="SELECT DISTINCT materia FROM libros_d WHERE materia LIKE '".$str."%' ORDER BY materia ASC";
	$resultado=mysql_query($sql);
	$data = array();
    while ($fila=mysql_fetch_assoc($resultado)) {
	    array_push($data, $fila['materia']);	
       
    }
    }
	*/
    //return json data
	return($data);
    //echo json_encode($data);
 }
 
 
 }