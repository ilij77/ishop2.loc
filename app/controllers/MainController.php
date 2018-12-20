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


        $this->setMeta('Главная страница', 'Описание', 'Ключевики');

    }

}