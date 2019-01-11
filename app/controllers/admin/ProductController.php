<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 10.01.2019
 * Time: 2:47
 */

namespace app\controllers\admin;


use app\models\admin\Product;
use app\models\AppModel;
use ishop\libs\Pagination;

class ProductController extends AppController
{
    public function indexAction(){
     $page=isset($_GET['page'])?(int)$_GET['page']:1;
     $perpage=10;
     $count=\RedBeanPHP\R::count('product');
     $pagination=new Pagination($page,$perpage,$count);
     $start=$pagination->getStart();
     $products=\RedBeanPHP\R::getAll("SELECT product.*, category.title AS cat FROM product JOIN category ON category.id=product.category_id ORDER BY product.title LIMIT $start,$perpage");
$this->setMeta('Список товаров');
$this->set(compact('products','pagination','count'));

    }

    public function addAction (){

        if (!empty($_POST)){
            $product=new Product();
            $data=$_POST;
            $product->load($data);
            $product->attributes['status']=$product->attributes['status'] ? '1' : '0';
            $product->attributes['hit']=$product->attributes['hit'] ? '1' : '0';
            if (!$product->validate($data)){
                $product->getErrors();
                $_SESSION['form_data']=$data;
                redirect();
            }
            if ($id=$product->save('product')){
                $alias=AppModel::createAlias('product','alias',$data['title'],$id);
                //debug($alias);
               $p= \RedBeanPHP\R::load('product',$id);
               $p->alias=$alias;
               \RedBeanPHP\R::store($p);

                $_SESSION['success']='Товар успешно добавлен';
                redirect();
            }


        }

     $this->setMeta('Новый товар');
    }

}