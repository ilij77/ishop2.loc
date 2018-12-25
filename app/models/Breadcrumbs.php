<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 26.12.2018
 * Time: 2:06
 */

namespace app\models;


use ishop\App;

class Breadcrumbs extends AppModel
{
    public static function getBreadcrumbs($category_id,$name='')
    {
        $cats=App::$app->getProperty('cats');
        $breadcrumbs_array=self::setParts($cats,$category_id);
        $breadcrumbs="<li><a href='".PATH."'> Главная</a></li>";
        if ($breadcrumbs_array){
            foreach ($breadcrumbs_array as $alias=>$title){
                $breadcrumbs.="<li><a href='".PATH."/category/{$alias}'>{$title}</a></li>";
            }
        }
        if ($name){
            $breadcrumbs.="<li>$name</li>";
        }
        return $breadcrumbs;
        //debug($breadcrumbs);



    }

    public static function setParts($cats,$id)
    {
        if (!$id) return false;
        $breadcrumbs=[];
        foreach ($cats as $k=>$v){
            if (isset($cats[$id])){
                $breadcrumbs[$cats[$id]['alias']]=$cats[$id]['title'];
                $id=$cats[$id]['parent_id'];
            }else break;
        }
        return array_reverse($breadcrumbs);
    }

}