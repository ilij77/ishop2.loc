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

}