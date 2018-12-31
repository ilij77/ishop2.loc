<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 31.12.2018
 * Time: 2:00
 */

namespace app\controllers\admin;


use app\models\User;

class UserController extends AppController
{
    public function  loginAdminAction(){

        if (!empty($_POST)){
            $user=new User();
            if ($user->login(true)){
                $_SESSION['success']='Вы успешно авторизованы';
            }else{
                $_SESSION['error']='Логин или пароль введены неверно';
            }
            if (User::isAdmin()){
                redirect(ADMIN);
            }else{
                redirect();
            }
        }

        $this->layout='login';

    }

}