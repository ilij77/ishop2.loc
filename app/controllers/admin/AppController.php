<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 31.12.2018
 * Time: 0:39
 */

namespace app\controllers\admin;


use app\models\AppModel;
use app\models\User;
use ishop\base\Controller;

class AppController extends Controller
{
    public $layout='admin';

    public function __construct($route)
    {
        parent::__construct($route);

        if (!User::isAdmin() && $route['action']!='login-admin'){
            redirect(ADMIN.'/user/login-admin');
        }
        new AppModel();
    }

}