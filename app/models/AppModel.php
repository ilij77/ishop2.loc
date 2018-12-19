<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 16:49
 */

namespace app\models;


use ishop\base\Model;

class AppModel extends Model
{
    public function __construct($route)
    {
        parent::__construct($route);

        new AppModel();
        
    }

}