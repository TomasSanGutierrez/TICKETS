<?php
include_once("libreria/config.php");
session_start();
if ( !isset($_SESSION['username']) && !isset($_SESSION['userid']) ){
    if ( $idcnx = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) ){
             
        //if ( @mysql_select_db(DB_NAME,$idcnx) ){
       //LOGIN
    if (isset($_POST['login_username'])){
        $usern = mysqli_real_escape_string($idcnx, $_POST['login_username']);
        $passw = mysqli_real_escape_string($idcnx, $_POST['login_userpass']);
        $sql = "SELECT user, passwd, id, rol FROM personas WHERE (user = '$usern' OR email = '$usern') AND passwd = '" . md5($passw) . "' LIMIT 1";
        $res = mysqli_query($idcnx, $sql);
        if (!$res){ echo 'SQLErr:' . mysqli_error($idcnx); mysqli_close($idcnx); exit; }
        if (mysqli_num_rows($res) == 1){
            $user = mysqli_fetch_assoc($res);
            $_SESSION['username'] = $user['user'];
            $_SESSION['userid'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];
            echo 1;
            mysqli_close($idcnx);
            exit;
        } else {
            echo 0;
            mysqli_close($idcnx);
            exit;
        }
    }
        //}
		

		
	//REGISTRO
    if (isset($_POST['rec_username'])){
        $usern = mysqli_real_escape_string($idcnx, $_POST['rec_username']);
        $passw = mysqli_real_escape_string($idcnx, $_POST['rec_userpass']);
        $email = mysqli_real_escape_string($idcnx, $_POST['rec_email']);

        // Verificar si usuario ya existe
        $chk = mysqli_query($idcnx, "SELECT id FROM personas WHERE user = '$usern' LIMIT 1");
        if (!$chk){ echo 'SQLErr:' . mysqli_error($idcnx); mysqli_close($idcnx); exit; }
        if (mysqli_num_rows($chk) > 0){ echo 'EXISTS'; mysqli_close($idcnx); exit; }

        $sql = "INSERT INTO personas (nombre,apellido,sexo,user,passwd,email,rol) VALUES ('". $usern ."','','','". $usern ."','". md5($passw) ."','". $email ."','estudiante')";
        if (!mysqli_query($idcnx, $sql)){ echo 'SQLErr:' . mysqli_error($idcnx); mysqli_close($idcnx); exit; }
        echo 1;
    }
		
		
             
        mysqli_close($idcnx);
    }
    else
        echo 0;
}
else{
    echo 0;
}

?>