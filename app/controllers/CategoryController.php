<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 28.12.2018
 * Time: 2:28
 */

namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Category;
use ishop\App;
use ishop\libs\Pagination;

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
        $page=isset($_GET['page'])?$_GET['page']:1;
        $perpage=App::$app->getProperty('pagination');
        $pagination=new Pagination($page,$perpage,20);
        echo $pagination;



        //хлебные крошки
        $breadcrumbs=Breadcrumbs::getBreadcrumbs($category->id);
        //debug($breadcrumbs);


        $cat_model=new Category();
        $ids=$cat_model->getIds($category->id);
        $ids=!$ids? $category->id : $ids.$category->id;
        //debug($ids);
        $products=\RedBeanPHP\R::findAll('product',"category_id IN ($ids)");
        //debug($products);
        $this->setMeta($category->title,$category->description,$category->keywords);
        $this->set(compact('products','breadcrumbs'));







    }

}