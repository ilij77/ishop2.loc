<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 24.12.2018
 * Time: 0:28
 */

namespace app\controllers;


class CurrencyController extends AppController
{
    public function changeAction()
    {
        $currency=!empty($_GET['curr']) ? $_GET['curr'] : null;
        if ($currency){
            $curr=\RedBeanPHP\R::find('currency','code=?',[$currency]);
            if (!empty($curr)){
                setcookie('currency',$currency,time()+3600*24*7,'/');
            }
        }
        redirect();
    }

}