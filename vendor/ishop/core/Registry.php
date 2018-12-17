<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 17.12.2018
 * Time: 2:37
 */

namespace ishop;


class Registry
{
use TSingleton;
public static $properties=[];

   public function setProperty ($name,$value)
    {
       self::$properties[$name]=$value;

}

    public function getProperty($name)
    {
       if(isset(self::$properties[$name])){
           return self::$properties[$name];
       }return null;
}

    public function getProperties()
    {
        return self::$properties;

}

}