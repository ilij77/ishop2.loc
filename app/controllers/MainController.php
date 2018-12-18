<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 18.12.2018
 * Time: 3:21
 */

namespace app\controllers;




use ishop\App;

class MainController extends AppController
{




    public function indexAction()
    {
        $this->setMeta(App::$app->getProperty('shop_name'),'Описание','Ключевики');

        $name='John';
        $age=30;
        $names=['Andrei','John'];
       $this->set(compact('name','age','names'));
    }

}