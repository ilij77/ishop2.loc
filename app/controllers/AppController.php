<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 0:57
 */

namespace app\controllers;


use app\models\AppModel;
use ishop\base\Controller;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();

    }

}