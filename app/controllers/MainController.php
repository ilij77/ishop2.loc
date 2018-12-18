<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 18.12.2018
 * Time: 3:21
 */

namespace app\controllers;




class MainController extends AppController
{




    public function indexAction()
    {
        $this->setMeta('111','111','111');
       debug($this->route);
        //echo __METHOD__;
    }

}