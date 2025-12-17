<?php
$base='http://localhost/bib-t1';
$loginUrl = $base.'/log.inout.ajax.php';
$indexUrl = $base.'/index.php';
$cookie = sys_get_temp_dir().'/test_admin_cookie.txt';
function post($url,$data,$cookie){
    $ch=curl_init($url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie);
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $r=curl_exec($ch);curl_close($ch);return $r;
}
function get($url,$cookie){
    $ch=curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    $r=curl_exec($ch);curl_close($ch);return $r;
}
$res=post($loginUrl,['login_username'=>'cm','login_userpass'=>'1234'],$cookie);
echo "Login cm -> ".trim($res)."\n";
$index=get($indexUrl,$cookie);
$hasUsers = (strpos($index,'>Usuarios<')!==false)?'YES':'NO';
$hasOnline = (strpos($index,'Usuarios en línea')!==false)?'YES':'NO';
echo "Index shows Usuarios link? $hasUsers\n";
echo "Index shows 'Usuarios en línea'? $hasOnline\n";
@unlink($cookie);
?>