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
        $countNewOrders=\RedBeanPHP\R::count('order', "status='0'");
        //debug($countNewOrders);
        $countUsers=\RedBeanPHP\R::count('user');
        $countProducts=\RedBeanPHP\R::count('product');
        $countCategories=\RedBeanPHP\R::count('category');
        $this->set(compact('countNewOrders','countProducts','countCategories','countUsers'));

        $this->setMeta('Панель управления');
        
    }

}