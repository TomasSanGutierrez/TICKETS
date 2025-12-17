<?php
// Simple test script to POST to log.inout.ajax.php
function post($url, $data){
    $opts = ['http' => [
        'method' => 'POST',
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($data),
        'timeout' => 5,
    ]];
    $context = stream_context_create($opts);
    return @file_get_contents($url, false, $context);
}

$base = 'http://localhost/bib-t1/log.inout.ajax.php';

// Test register
$rand = 'u'.rand(1000,9999);
$reg = post($base, ['rec_username' => $rand, 'rec_userpass' => 'test1234', 'rec_email' => $rand.'@example.com']);
echo "Register response for $rand: ".$reg."\n";

// Try duplicate register
$reg2 = post($base, ['rec_username' => $rand, 'rec_userpass' => 'test1234', 'rec_email' => $rand.'@example.com']);
echo "Duplicate register response for $rand: ".$reg2."\n";

// Test login
$login = post($base, ['login_username' => $rand, 'login_userpass' => 'test1234']);
echo "Login response for $rand: ".$login."\n";

// Test wrong password
$login2 = post($base, ['login_username' => $rand, 'login_userpass' => 'wrongpass']);
echo "Login wrong password for $rand: ".$login2."\n";

?>