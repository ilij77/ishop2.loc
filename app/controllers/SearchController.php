<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 28.12.2018
 * Time: 0:40
 */

namespace app\controllers;


class SearchController extends AppController
{
    public function typeaheadAction()
    {
        if ($this->isAjax()){
            $query=!empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
            if ($query){
                $products=\RedBeanPHP\R::getAll("SELECT id,title FROM product WHERE  title LIKE ? AND status='1' LIMIT 11",["%{$query}%"]);
                echo  json_encode($products);
            }
        }die;
        
    }

    public function indexAction(){


            $query=!empty(trim($_GET['s'])) ? trim($_GET['s']) : null;
            if ($query){
            $products=\RedBeanPHP\R::find('product', "title LIKE ? AND status='1'",["%{$query}%"]);
            }

            $this->setMeta('Поиск по:'.h($query));
            $this->set(compact('products','query'));


    }

}