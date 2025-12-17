function cargar_txt(div,desde){
   
   var ruta="txts/" + desde;
   $.ajax({
        type: "POST",
        url: "ver_txt.php",
        data: {archivo: ruta}
    }).done(function (html) {
        $(div).html(html);
    });
   } 
   
   function cargar(div,desde)
   {
   $(div).load(desde);
   } 
   
function cargar_media(div,archivo){
   // Post the raw archivo to ver_media so it can handle youtube, mp4 or pdf.
   $.ajax({
        type: "POST",
        url: "ver_media.php",
        data: {archivo: archivo}
    }).done(function (html) {
        $(div).html(html);
    });
}
