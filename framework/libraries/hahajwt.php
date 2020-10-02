<?php

require_once 'jwt.php';
$ma = $_SERVER['REQUEST_METHOD'];
$jwt = new Jwt;
if ($ma == 'GET') {
    $payload=array('sub'=>'1234567890','name'=>'John Doe','iat'=>1516239022, 'exp'=>time()+7200);
    $token = $jwt->getToken($payload);
    echo $token;
} elseif ($ma == 'POST') 
{
    $p = $jwt->verifyToken($_SERVER['HTTP_AUTHORIZATION']);
    // echo $_SERVER['HTTP_ZATION'];
    // echo 'lskdfj';
    var_dump($p);
}
// echo 'jksdl';