<?php
function post($url,$data){$opts=['http'=>['method'=>'POST','header'=>'Content-type: application/x-www-form-urlencoded','content'=>http_build_query($data)]];return @file_get_contents($url,false,stream_context_create($opts));}
$base='http://localhost/bib-t1/log.inout.ajax.php';
$res=post($base,['login_username'=>'p_luisss@yahoo.com.ar','login_userpass'=>'1234']);
echo "Login via email -> ".trim($res)."\n";
?>