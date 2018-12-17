<?php

define("DEBUG",1);
define("ROOT",dirname(__DIR__));
define("WWW",ROOT . '/public');
define("APP",ROOT . '/app');
define("CORE",ROOT . '/vendor/ishop/core');
define("LIBS",ROOT . '/vendor/ishop/core/libs');
define("CASHE",ROOT . '/tmp/cashe');
define("CONF",ROOT . '/config');
define("LAYOUT",'default');

//$app_path="http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
//$app_path=preg_replace("#[^/]+$#",'',$app_path);
//$app_path=str_replace('public/','',$app_path);
//echo $w=$_SERVER['HTTP_HOST'];

define("PATH","http://{$_SERVER['HTTP_HOST']}");
define("ADMIN",PATH .'/admin');


require_once ROOT .'/vendor/autoload.php';
