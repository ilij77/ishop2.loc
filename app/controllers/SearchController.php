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
                $products=\RedBeanPHP\R::getAll('SELECT id,title FROM product WHERE  title LIKE ? LIMIT 11',["%{$query}%"]);
                echo  json_encode($products);
            }
        }die;
        
    }

}