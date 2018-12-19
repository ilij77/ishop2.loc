<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 15:57
 */

namespace ishop\base;


use ishop\Db;

abstract class Model
{
    private $attributes=[];
    public $errors=[];
    public $rules=[];

    public function  __construct()
    {
        Db::instance();
    }

}