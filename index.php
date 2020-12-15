<?php
header("Content-type: application/json;charset=UTF-8");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Origin:*');
header("Access-Control-Request-Methods:GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers:*');
require_once 'framework/core/Framework.class.php';
date_default_timezone_set('Asia/Shanghai');

Framework::run();
