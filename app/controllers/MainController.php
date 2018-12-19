<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 18.12.2018
 * Time: 3:21
 */

namespace app\controllers;




use ishop\App;
use ishop\Cashe;

class MainController extends AppController
{




    public function indexAction()
    {

        $posts=\RedBeanPHP\R::findAll('test');
        //debug($posts);

        $this->setMeta(App::$app->getProperty('shop_name'),'Описание','Ключевики');

        $name='John';
        $age=30;
        $names=['Andrei','John'];
        $cashe=Cashe::instance();
         //$cashe->set('test',$names);
         //$cashe->delete('test');

        $data=$cashe->get('test');

      debug($data);


       $this->set(compact('name','age','names','posts'));
    }

}