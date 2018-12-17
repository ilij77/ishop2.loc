<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 17.12.2018
 * Time: 2:11
 */

namespace ishop;


class App
{
    public static $app;

    public function __construct()
    {
        $query=trim($_SERVER['QUERY_STRING'],'/');

        session_start();
        self::$app=Registry::instance();
        $this->getParams();
        new ErrorHandler();


    }
    protected function getParams(){
        $params=require_once CONF . '/params.php';
        //var_dump($params);
        if (!empty($params)){
            foreach ($params as $k =>$v){
                self::$app->setProperty($k,$v);
            }
            //var_dump(self::$app);
        }

    }

}