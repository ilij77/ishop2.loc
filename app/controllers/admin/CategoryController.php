<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 09.01.2019
 * Time: 13:43
 */

namespace app\controllers\admin;


class CategoryController extends AppController
{
    public function indexAction(){
        $this->setMeta('Список категорий');
    }
    public function deleteAction(){
        $id=$this->getRequestID();
        $children=\RedBeanPHP\R::count('category','parent_id=?',[$id]);
        //debug($children,true);
        $errors='';
        if ($children){
            $errors.='<li>Удаление невозможно, в категории есть вложенные категории</li>';
        }
        $products=\RedBeanPHP\R::count('product','category_id=?',[$id]);
        if ($products){
            $errors.='<li>Удаление невозможно, в категории есть товары</li>';
        }
        if ($errors){
            $_SESSION['error']="<ul>$errors</ul>";
            redirect();
        }
        $category=\RedBeanPHP\R::load('category',$id);
        \RedBeanPHP\R::trash($category);
        $_SESSION['success']='Категория удалена';
        redirect();

    }

}