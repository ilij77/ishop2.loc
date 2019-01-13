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

    public function editAction(){

        if (!empty($_POST)){
           $id=$this->getRequestID(false);
           $product=new Product();
           $data=$_POST;
           $product->load($data);
           $product->attributes['status']=$product->attributes['status'] ? '1' : '0';
           $product->attributes['hit']=$product->attributes['hit'] ? '1' : '0';
           $product->getImg();
            if (!$product->validate($data)){
                $product->getErrors();
               redirect();
            }
            if ($id=$product->update('product',$id)){

                $product->editFilter($id,$data);
                $product->editRelatedProduct($id,$data);
                $product->saveGallery($id);
                $alias=AppModel::createAlias('product','alias',$data['title'],$id);
                $product=\RedBeanPHP\R::load('product',$id);
                $product->alias=$alias;
                \RedBeanPHP\R::store($product);
                $_SESSION['success']='Изменения сохранены';
                redirect();
            }



        }
        $id=$this->getRequestID();
        $product=\RedBeanPHP\R::load('product',$id);
        App::$app->setProperty('parent_id',$product->category_id);
        $filter=\RedBeanPHP\R::getCol('SELECT attr_id FROM attribute_product WHERE product_id=?',[$id]);
        $related_product=\RedBeanPHP\R::getAll("SELECT related_product.related_id,
 product.title FROM related_product JOIN  product ON product.id=related_product.related_id 
 WHERE related_product.product_id=?",[$id]);
        $gallery=\RedBeanPHP\R::getCol('SELECT img FROM gallery WHERE product_id=?',[$id]);
        $this->setMeta('Редактирование товара');
        $this->set(compact('product','filter','related_product','gallery'));

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

    public function deleteGalleryAction(){
        $id=isset($_POST['id'])?$_POST['id']:null;
        $src=isset($_POST['src'])?$_POST['src']:null;
        if (!$id||!$src){
            return;
        }
        if (\RedBeanPHP\R::exec("DELETE FROM gallery WHERE product_id=? AND img=?",[$id,$src]));{
        @unlink(WWW."/images/$src");
        exit('1');
    }
    return;
    }




}