<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 31.12.2018
 * Time: 0:38
 */

namespace app\controllers\admin;


class mainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta('Панель управления');
        
    }

}