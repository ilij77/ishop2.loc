<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 25.12.2018
 * Time: 0:39
 */

namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Product;

class ProductController extends AppController
{
    public function viewAction()
    {
        $alias=$this->route['alias'];
        $product=\RedBeanPHP\R::findOne('product',"alias=? AND status='1'",[$alias]);
        //debug($product);
        if (!$product){
            throw new \Exception('Страница не найдена',404);
        }


        //хлебные крошки

        $breadcrumbs=Breadcrumbs::getBreadcrumbs($product->category_id,$product->title);
        //debug($breadcrumbs);
        //связанные товары

        $related=\RedBeanPHP\R::getAll("SELECT*FROM related_product JOIN product ON product.id=related_product.related_id WHERE related_product.product_id=?",[$product->id]);

        //debug($related);


        //запись в куки запрашиваемого товара
       $p_model=new Product();
       $p_model->setRecentlyViewed($product->id);

        //просмотренные товары
        $r_viewed=$p_model->getRecentlyViewed();

        //debug($r_viewed);
        $recentlyViewed=null;
        if ($r_viewed){
            $recentlyViewed=\RedBeanPHP\R::find('product','id IN ('.\RedBeanPHP\R::genSlots($r_viewed).') LIMIT 3',$r_viewed);
        }
        //debug($recentlyViewed);



        //галерея
        $gallery=\RedBeanPHP\R::findAll('gallery','product_id=?',[$product->id]);
        //debug($gallery);

        //модификации
        $this->setMeta($product->title,$product->description,$product->keywords);
        $this->set(compact('product','related','gallery','recentlyViewed','breadcrumbs'));

        
    }


}