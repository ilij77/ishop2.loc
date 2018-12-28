<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 28.12.2018
 * Time: 15:52
 */

namespace app\controllers;


use app\models\User;

class UserController extends AppController
{




    public function signupAction(){
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            //debug($data);
            $user->load($data);
            //debug($user);
            die;
        }}



    public function loginAction(){

    }
    public function logoutAction(){

    }
}