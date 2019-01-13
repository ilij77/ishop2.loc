<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 13.01.2019
 * Time: 16:24
 */

namespace app\models\admin;


use app\models\AppModel;

class FilterAttr extends AppModel
{
    public $attributes=[
        'value'=>'',
        'attr_group_id'=>'',
    ];
    public  $rules=[
        'required'=>[
            ['value'],
            ['attr_group_id'],
        ],
        'integer'=>[
            ['attr_group_id'],
        ],
    ];

}