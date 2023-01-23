<?php

declare(strict_types=1);
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once('vendor/autoload.php');
session_start();

function generateJWT(){

    $date   = new DateTimeImmutable();
    $expire_at     = $date->modify('+6 minutes')->getTimestamp(); 

    $payload = [];
    $request_data = [
    'iat'  => $date->getTimestamp(),         // Issued at: time when the token was generated
    'nbf'  => $date->getTimestamp(),         // Not before
    'exp'  => $expire_at,                           // Expire
    
    ];

    $key = getenv("SECRET_KEY");
    switch ($_SESSION['sessLogin_type']) {
        case "admin":
            $payload = [
                'admin_login' => true,
                'sessUsername' => $_SESSION['txtUsername'],
                'sessPassword' => $_SESSION['txtPassword'],
            ];
            break;

        case "manufacturer":
            $payload = [
                'manufacturer_login' => true,
                'sessUsername' => $_SESSION['txtUsername'],
                'sessPassword' => $_SESSION['txtPassword'],
                'manufacturer_id' => $_SESSION['man_id']
            ];
            break;

        case "retailer":
            $payload = [
                'retailer_login' => true,
                'sessUsername' => $_SESSION['txtUsername'],
                'sessPassword' => $_SESSION['txtPassword'],
                'retailer_id' => $_SESSION['retailer_id']
            ];
            break;
           
    }
    $jwt = JWT::encode($request_data,$payload, $key, 'HS256');
            setcookie('cert', $jwt);
};

function decode(){
   
	if(isset($_COOKIE['cert'])) {
		$key = getenv("SECRET_KEY");
		$decoded = JWT::decode($_COOKIE['cert'], new Key($key, 'HS256'));

    if($decoded ->admin_login . PHP_EOL == 1) {
        $_SESSION['admin_login'] = true;
        $_SESSION['sessUsername'] = $decoded ->sessUsername;
        $_SESSION['sessPassword'] = $decoded ->sessPassword;
    }
    else if($decoded->manufacturer_login . PHP_EOL == 1){
        $_SESSION['manufacturer_login'] = true;
        $_SESSION['sessUsername'] = $decoded ->sessUsername;
        $_SESSION['sessPassword'] = $decoded ->sessPassword;
        $_SESSION['manufacturer_id'] =  $decoded ->manufacturer_id;
    }
    else if($decoded ->retailer_login . PHP_EOL == 1){
        $_SESSION['retailer_login'] = true;
        $_SESSION['sessUsername'] = $decoded ->sessUsername;
        $_SESSION['sessPassword'] = $decoded ->sessPassword;
        $_SESSION['retailer_id'] =  $decoded ->retailer_id;
    }
}
};
?>