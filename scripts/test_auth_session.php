<?php
// Test login via curl, preserve cookies and validate session presence in index.php
$base = 'http://localhost/bib-t1';
$loginUrl = $base . '/log.inout.ajax.php';
$indexUrl = $base . '/index.php';
$cookieFile = sys_get_temp_dir() . '/test_auth_cookie.txt';
$rand = 's' . rand(1000,9999);
$email = $rand . '@example.com';

function curlPost($url, $data, $cookieFile){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    // ignore SSL issues for localhost
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err) return 'CURLERR:' . $err;
    return $res;
}

function curlGet($url, $cookieFile){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err) return 'CURLERR:' . $err;
    return $res;
}

// 1) Register
$reg = curlPost($loginUrl, ['rec_username' => $rand, 'rec_userpass' => 'testpass123', 'rec_email' => $email], $cookieFile);
echo "Register ($rand): $reg\n";

// 2) Login
$login = curlPost($loginUrl, ['login_username' => $rand, 'login_userpass' => 'testpass123'], $cookieFile);
echo "Login ($rand): $login\n";

// 3) Fetch index.php with cookie
$index = curlGet($indexUrl, $cookieFile);
$found = (strpos($index, $rand) !== false) ? 'YES' : 'NO';
echo "Index contains username? $found\n";

// 4) Logout
$logout = curlGet($base . '/logout.php', $cookieFile);
$index2 = curlGet($indexUrl, $cookieFile);
$found2 = (strpos($index2, $rand) !== false) ? 'YES' : 'NO';
echo "After logout, index contains username? $found2\n";

// Cleanup
@unlink($cookieFile);

?>