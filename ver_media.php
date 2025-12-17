<?php
if (!empty($_POST)) {
    $file = $_POST['archivo'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
}
?>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div id="capa_media">
<?php
if (isset($ext)){
    // handle audio
    if (in_array($ext, ['mp3','wav','ogg'])){
        echo "<audio controls style='width:100%'><source src='$file' type='audio/{$ext}'>Tu navegador no soporta audio HTML5.</audio>";
    }
    // handle video files
    elseif (in_array($ext, ['mp4','webm','ogg'])){
        echo "<video controls style='width:100%; max-height:500px; background:#000'><source src='$file' type='video/{$ext}'>Tu navegador no soporta video HTML5.</video>";
    }
    // handle pdf
    elseif ($ext === 'pdf'){
        // use iframe for inline PDF preview; provide a neutral 'Documento' link as fallback
        echo "<iframe src='$file' width='100%' height='600' style='border:0'></iframe>";
        echo "<p style='margin-top:8px;'><a href='$file' target='_blank'>Documento</a></p>";
    }
    // if extension is not known, check for youtube URL
    else {
        if (preg_match('/youtu(?:\.be|be\.com)\/([A-Za-z0-9_\-]+)/i',$file,$m)){
            $ytid = $m[1];
            echo "<div style='position:relative;padding-bottom:56.25%;height:0;overflow:hidden;max-width:100%'><iframe src='https://www.youtube.com/embed/".$ytid."' style='position:absolute;top:0;left:0;width:100%;height:100%;' frameborder='0' allowfullscreen></iframe></div>";
        } else {
            echo "<p>Vista previa no disponible para este tipo de archivo. <a href='$file' target='_blank'>Abrir</a></p>";
        }
    }
} else {
    echo "<p>No se especificó archivo</p>";
}
?>
      </div>
    </div>
  </div>
</div>