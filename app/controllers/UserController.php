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
                $_SESSION['form_data']=$data;

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

        if (!empty($_POST)){
            $user=new User();
            if ($user->login()){
                $_SESSION['success']='Вы успешно авторизованы';
            }else{
                $_SESSION['error']='Логин или пароль введены неверно';
            }
            redirect();

        }


        $this->setMeta('Вход');
    }
    public function logoutAction(){

        if ($_SESSION['user']) unset($_SESSION['user']);
        $_SESSION['success']='Вы успешно вышли из учетной записи';
        redirect();

    }
}