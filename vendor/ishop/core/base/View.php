<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 1:07
 */

namespace ishop\base;


class View
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $data=[];
    public $meta=[];
    public $layout;

    public function __construct($route,$layout='',$view='',$meta)
    {
        $this->route=$route;
        $this->controller=$route['controller'];
        $this->view=$view;
        $this->meta=$meta;
        $this->model=$route['controller'];
        $this->prefix=$route['prefix'];
        if ($layout===false){
            $this->layout=false;
        }else{
            $this->layout=$layout ?: LAYOUT;
        }





    }

}