<?php
// Simple help page
include('menu_bs.php');

echo '<div class="container">';
echo '<h2>Ayuda</h2>';
echo '<p>Bienvenido a la sección de Ayuda. Aquí podrá encontrar información de soporte y recursos.</p>';
echo '<p>Abajo se muestran los carteles de la categoría <strong>Ayuda</strong>:</p>';
echo '<div id="ayuda_cartelera">';
// Load the Ayuda carteles directly
include_once('mostrar_cartelera.php');
// mostrar_cartelera.php reads $_GET['b'], ensure it's set
// If not set explicitly, set it here
?>
<script>
// Load the hoja of Ayuda into current content area (for AJAX usage)
// If this file is loaded directly, show the carteles as below
$.get('mostrar_cartelera.php?b=Ayuda', function(data){
    $('#ayuda_cartelera').html(data);
});
</script>
<?php
echo '</div>';
echo '</div>';
?>