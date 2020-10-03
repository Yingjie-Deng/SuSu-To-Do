<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type,Authorization');
require_once 'framework/core/Framework.class.php';

Framework::run();
?>