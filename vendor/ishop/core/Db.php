<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 16:16
 */

namespace ishop;


class Db
{
    use TSingleton;
protected function __construct()
{
    $db=require_once CONF .'/config_db.php';
}
}