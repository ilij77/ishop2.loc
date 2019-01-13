<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 14.01.2019
 * Time: 0:34
 */

namespace app\controllers\admin;


use app\models\admin\Currency;

class CurrencyController extends AppController
{
    public function indexAction(){
        $currencies=\RedBeanPHP\R::findAll('currency');
        $this->set(compact('currencies'));
        $this->setMeta('Валюты магазина');

    }


    public function addAction(){
        if (!empty($_POST)){
            $currency=new Currency();
            $data=$_POST;
            $currency->load($data);
            $currency->attributes['base']=$currency->attributes['base'] ? '1' : '0';
            if (!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if ($currency->save('currency'));
            $_SESSION['success']='Новая валюта успешно добавлена';
            redirect();

        }
        $this->setMeta('Новая валюта');

    }
    public function deleteAction(){
        $id = $this->getRequestID();
        $currency = \RedBeanPHP\R::load('currency', $id);
        \RedBeanPHP\R::trash($currency);
        $_SESSION['success'] = "Валюта удалена";
        redirect();
    }

    public function editAction(){
        if(!empty($_POST)){
            $id = $this->getRequestID(false);
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? '1' : '0';
            if(!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if($currency->update('currency', $id)){
                $_SESSION['success'] = "Изменения сохранены";
                redirect();
            }
        }

        $id = $this->getRequestID();
        $currency = \RedBeanPHP\R::load('currency', $id);
        $this->setMeta("Редактирование валюты {$currency->title}");
        $this->set(compact('currency'));
    }
}