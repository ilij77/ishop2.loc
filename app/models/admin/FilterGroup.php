<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 13.01.2019
 * Time: 16:23
 */

namespace app\models\admin;


use app\models\AppModel;

class FilterGroup extends AppModel
{
    public $attributes=[
        'title'=>'',
    ];
    public  $rules=[
        'required'=>[
            ['title'],
        ],
];

}