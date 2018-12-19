<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 16:16
 */

namespace ishop;
use \RedBeanPHP\R as R;

class Db
{
    use TSingleton;
protected function __construct()
{


    $db=require_once CONF .'/config_db.php';
    \R::setup($db['dsn'],$db['user'],$db['pass']);
    if (!\R::testConnection()){
        throw new\Exception('Нет соединения с базой данных',500);
    }
}
}