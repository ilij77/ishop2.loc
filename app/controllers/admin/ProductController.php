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
use ishop\App;
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
            //debug($data,true);
            $product->load($data);
            $product->attributes['status']=$product->attributes['status'] ? '1' : '0';
            $product->attributes['hit']=$product->attributes['hit'] ? '1' : '0';
            $product->getImg();
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
               $product->editFilter($id,$data);
               $product->editRelatedProduct($id,$data);
               //debug($data,true);
                $product->saveGallery($id);

                $_SESSION['success']='Товар успешно добавлен';
                redirect();
            }


        }

     $this->setMeta('Новый товар');
    }
    public function relatedProductAction(){
        $q=isset($_GET['q'])?$_GET['q']:'';
        $data['items']=[];
        $products=\RedBeanPHP\R::getAssoc('SELECT id,title FROM product WHERE title LIKE ? LIMIT 10',["%{$q}%"]);
        if ($products){
            $i=0;
            foreach ($products as $id=>$title){
                $data['items'][$i]['id']=$id;
                $data['items'][$i]['text']=$title;
                $i++;
            }
        }
 echo json_encode($data);
        die;
    }

    public function addImageAction(){
        if (isset($_GET['upload'])){
            if ($_POST['name']=='single'){
                $wmax=App::$app->getProperty('img_width');
                $hmax=App::$app->getProperty('img_height');

            }
            if ($_POST['name']=='multi'){
                $wmax=App::$app->getProperty('gallery_width');

                $hmax=App::$app->getProperty('gallery_height');

            }
            $name=$_POST['name'];
            $product=new Product();
            $product->uploadImg($name,$wmax,$hmax);

        }
    }


}