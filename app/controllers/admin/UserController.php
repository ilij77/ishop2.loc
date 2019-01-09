<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 31.12.2018
 * Time: 2:00
 */

namespace app\controllers\admin;


use app\models\User;
use ishop\libs\Pagination;

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

    public function indexAction(){
        $page=isset($_GET['page']) ? (int)$_GET['page'] :1;
        $perpage=3;
        $count=\RedBeanPHP\R::count('user');
        $pagination=new Pagination($page,$perpage,$count);
        $start=$pagination->getStart();
        $users=\RedBeanPHP\R::findAll('user',"LIMIT $start,$perpage");

        $this->setMeta('Список пользователей');
        $this->set(compact('users','pagination','count'));


    }
    public function editAction(){
        $user_id=$this->getRequestID();
        $user=\RedBeanPHP\R::load('user',$user_id);
        $this->setMeta('Редактирование профиля пользователя');
        $this->set(compact('user'));
    }

}