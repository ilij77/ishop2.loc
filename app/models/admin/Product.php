<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 10.01.2019
 * Time: 2:48
 */

namespace app\models\admin;


use app\models\AppModel;

class Product extends AppModel
{
    public $attributes=[
        'title'=>'',
        'category_id'=>'',
        'keywords'=>'',
        'description'=>'',
        'price'=>'',
        'old_price'=>'',
        'content'=>'',
        'status'=>'',
        'hit'=>'',
        'alias'=>'',
    ];
    public $rules=[
        'required'=>[
            ['title'],
            ['category_id'],
            ['price'],
        ],
        'integer'=>[
            ['categiry_id'],

        ],
    ];
    public function editFilter($id,$data){
        $filter=\RedBeanPHP\R::getCol('SELECT attr_id FROM attribute_product WHERE product_id=?',[$id]);

        if (empty($data['attrs'])&&!empty($filter)){
            \RedBeanPHP\R::exec("DELETE FROM attribute_product WHERE product_id=?",[$id]);
            return;
        }

        if (empty($filter)&&!empty($data['attrs'])){
            $sql_part='';
            foreach ($data['attrs'] as $v){
               $sql_part.="($v,$id),";
            }
            $sql_part=rtrim($sql_part,',');
            \RedBeanPHP\R::exec("INSERT INTO attribute_product (attr_id, product_id) VALUES $sql_part");
            return;
        }

        if (!empty($data['attrs'])){
            $result=array_diff($filter,$data['attrs']);
            if ($result){
                \RedBeanPHP\R::exec("DELETE FROM attribute_product WHERE product_id=?",[$id]);
                $sql_part='';
                foreach ($data['attrs'] as $v){
                    $sql_part.="($v,$id),";
                }
                $sql_part=rtrim($sql_part,',');
                \RedBeanPHP\R::exec("INSERT INTO attribute_product (attr_id, product_id) VALUES $sql_part");
                return;
            }
        }

    }

}