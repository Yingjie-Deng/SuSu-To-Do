<?php
header("Content-type: application/json;charset=UTF-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Origin:*');
header("Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers:Accept,Authorization,Cache-Control,Content-Type,DNT,If-Modified-Since,Keep-Alive,Origin,User-Agent,X-Requested-With,Token,x-access-token,authorization');
require_once 'framework/core/Framework.class.php';

Framework::run();
?>