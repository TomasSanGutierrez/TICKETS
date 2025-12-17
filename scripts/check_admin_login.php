<?php
function post($url,$data){
    $opts = ['http' => ['method'=>'POST','header'=>'Content-type: application/x-www-form-urlencoded','content'=>http_build_query($data)]];
    $ctx = stream_context_create($opts);
    return @file_get_contents($url,false,$ctx);
}
$base='http://localhost/bib-t1/log.inout.ajax.php';
$users=[['u'=>'cm','p'=>'1234'],['u'=>'lp','p'=>'1234'],['u'=>'nonexist','p'=>'1234']];
foreach($users as $u){
    $res=post($base,['login_username'=>$u['u'],'login_userpass'=>$u['p']]);
    echo "Login {$u['u']}: -> ".trim($res)."\n";
}
?>