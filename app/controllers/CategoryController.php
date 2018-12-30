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
use app\widgets\filter\Filter;
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



        //хлебные крошки
        $breadcrumbs=Breadcrumbs::getBreadcrumbs($category->id);
        //debug($breadcrumbs);


        $cat_model=new Category();
        $ids=$cat_model->getIds($category->id);
        $ids=!$ids? $category->id : $ids.$category->id;
        //debug($ids);

        //Пагинация
        $page=isset($_GET['page'])?$_GET['page']:1;
        $perpage=App::$app->getProperty('pagination');
       //debug($perpage);

        $sql_part='';

//Filtry

        if (!empty($_GET['filter'])){
            $filter=Filter::getFilter();
            $sql_part="AND id IN  (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter))";
        }




        $total=\RedBeanPHP\R::count('product',"category_id IN ($ids) $sql_part");
        $pagination=new Pagination($page,$perpage,$total);
        $start=$pagination->getStart();
        //echo $pagination;

        $products=\RedBeanPHP\R::findAll('product',"category_id IN ($ids) $sql_part LIMIT $start,$perpage");
        //debug($products);

        if ($this->isAjax()){

            $this->loadView('filter',compact('products','total','pagination'));
        }



        $this->setMeta($category->title,$category->description,$category->keywords);
        $this->set(compact('products','breadcrumbs','pagination','total'));










    }

}