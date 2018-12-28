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
            if (!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();

                //debug($user->errors);
            }else{
                $user->attributes['password']=password_hash($user->attributes['password'],PASSWORD_DEFAULT);
                if ($user->save('user')){
                $_SESSION['success']='Вы успешно зарегистрированы';

                }else{
                    $_SESSION['error']='Ошибка регистрации';
                }


            }redirect();

        }
        $this->setMeta('Регистрация');
    }



    public function loginAction(){

    }
    public function logoutAction(){

    }
}