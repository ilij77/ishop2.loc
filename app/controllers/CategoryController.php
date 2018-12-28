<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 28.12.2018
 * Time: 2:28
 */

namespace app\controllers;


use app\models\Category;

class CategoryController extends AppController
{
    public function viewAction(){
        $alias=$this->route['alias'];
        //debug($this->route);
        $category=\RedBeanPHP\R::findOne('category', 'alias =?',[$alias]);
        //debug($category);
        if (!$category){
           throw  new \Exception('Страница не найдена',404);
        }
        //хлубные крошки
        $breadcrubs='';
        $cat_model=new Category();
        $ids=$cat_model->getIds($category->id);
        $ids=!$ids? $category->id : $ids.$category->id;
        //debug($ids);
        $products=\RedBeanPHP\R::findAll('product',"category_id IN ($ids)");
        //debug($products);
        $this->setMeta($category->title,$category->description,$category->keywords);
        $this->set(compact('products','breadcrubs'));







    }

}