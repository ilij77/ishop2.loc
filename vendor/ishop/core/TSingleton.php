<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 17.12.2018
 * Time: 2:39
 */

namespace ishop;


trait TSingleton
{
    private static $instance;
    public static function  instance(){
        if (self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }

}