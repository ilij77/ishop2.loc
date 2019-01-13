<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 13.01.2019
 * Time: 15:41
 */

namespace app\controllers\admin;


use app\models\admin\FilterAttr;
use app\models\admin\FilterGroup;

class FilterController extends AppController
{
    public function groupDeleteAction(){
        $id=$this->getRequestID();
        $count=\RedBeanPHP\R::count('attribute_value','attr_group_id=?',[$id]);
        if ($count){
            $_SESSION['error']='Удаление невозможно в группе есть аттрибуты';
            redirect();
        }
        \RedBeanPHP\R::exec('DELETE FROM attribute_group WHERE id=?',[$id]);
        $_SESSION['success']='Группа успешно удалена';
        redirect();
    }


    public function groupEditAction(){
        if (!empty($_POST)){
            $id=$this->getRequestID(false);
            $group=new FilterGroup();
            $data=$_POST;
            $group->load($data);
            if (!$group->validate($data)){
                $group->getErrors();
                redirect();
            }
            if ($group->update('attribute_group',$id));
            $_SESSION['success']='Изменения сохранены';
            redirect();

        }
        $id=$this->getRequestID();
        $group=\RedBeanPHP\R::load('attribute_group',$id);
        $this->setMeta("Редактирование группы{$group->title}");
        $this->set(compact('group'));
    }



    public function groupAddAction(){
        if (!empty($_POST)){
            $group=new FilterGroup();
            $data=$_POST;
            $group->load($data);
            if (!$group->validate($data)){
                $group->getErrors();
                redirect();
            }
            if ($group->save('attribute_group',false));
            $_SESSION['success']='Группа успешно добавлена';
            redirect();

        }
        $this->setMeta('Новая группа фильтров');
    }

    public function attributeGroupAction(){
        $attrs_group=\RedBeanPHP\R::findAll('attribute_group');
        $this->setMeta('Группы фильтров');
        $this->set(compact('attrs_group'));

    }
    public function attributeAction(){
$attrs=\RedBeanPHP\R::getAssoc("SELECT attribute_value.*,attribute_group.title FROM
attribute_value JOIN attribute_group ON attribute_group.id=attribute_value.attr_group_id");
$this->setMeta('Фильтры');

//debug($attrs);
$this->set(compact('attrs'));
    }

    public function attributeEditAction(){

        if (!empty($_POST)){
            $id=$this->getRequestID(false);
            $attr=new FilterAttr();
            $data=$_POST;
            $attr->load($data);
            if (!$attr->validate($data)){
                $attr->getErrors();
                redirect();
            }
            if ($attr->update('attribute_value',$id)){
                $_SESSION['success']='Атрибут изменен';
                redirect();

            }
        }
        $id=$this->getRequestID();

        $attr=\RedBeanPHP\R::load('attribute_value',$id);
        $attrs_group=\RedBeanPHP\R::findAll('attribute_group');
        $this->set(compact('attr','attrs_group'));
        $this->setMeta('Редактирование атрибута');
    }


    public function attributeAddAction(){
        if (!empty($_POST)){
            $attr=new FilterAttr();
            $data=$_POST;
            $attr->load($data);
            if (!$attr->validate($data)){
                $attr->getErrors();
                redirect();
            }
             if ($attr->save('attribute_value',false)){
            $_SESSION['success']='Фильтр успешно добавлена';
            redirect();

       }
    }
        $group=\RedBeanPHP\R::findAll('attribute_group');
        $this->set(compact('group'));
        $this->setMeta('Новый фильтр');

}

}