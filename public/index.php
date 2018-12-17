<?php
require_once dirname(__DIR__).'/config/init.php';
require_once LIBS .'/function.php';

//var_dump($_SERVER['QUERY_STRING']);

new \ishop\App();


//debug(\ishop\App::$app->getProperties());
//var_dump(new \ishop\App());

throw new Exception('Страница не найдена', 500);