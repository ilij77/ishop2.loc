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
        $brands=\RedBeanPHP\R::find('brand','LIMIT 3');
        //debug($brands);
        $hits=\RedBeanPHP\R::find('product',"hit='1' AND status='1' LIMIT 8");



        $this->setMeta('Главная страница', 'Описание', 'Ключевики');
        $this->set(compact('brands','hits'));

    }

}