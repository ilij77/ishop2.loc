<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 25.12.2018
 * Time: 0:39
 */

namespace app\controllers;


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
        //связанные товары

        $related=\RedBeanPHP\R::getAll("SELECT*FROM related_product JOIN product ON product.id=related_product.related_id WHERE related_product.product_id=?",[$product->id]);

        //debug($related);


        //запись в куки запрашиваемого товара
        //просмотренные товары
        //галерея
        //модификации
        $this->setMeta($product->title,$product->description,$product->keywords);
        $this->set(compact('product','related'));

        
    }


}