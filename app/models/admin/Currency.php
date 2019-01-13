<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 14.01.2019
 * Time: 0:53
 */

namespace app\models\admin;


use app\models\AppModel;

class Currency extends AppModel
{
    public $attributes=[
        'title'=>'',
        'code'=>'',
        'symbol_left'=>'',
        'symbol_right'=>'',
        'value'=>'',
        'base'=>'',
    ];

    public $rules=[
        'required'=>[
            ['title'],
            ['code'],
            ['value'],
        ],
       'numeric'=>[
           ['value'],
       ],
    ];

}