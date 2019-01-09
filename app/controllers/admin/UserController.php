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

        if (!empty($_POST)){
            $id=$this->getRequestID(false);
            $user=new \app\models\admin\User();
            $data=$_POST;
            //debug($data);
            $user->load($data);
            if (!$user->attributes['password']){
                unset($user->attributes['password']);
            }else{
                $user->attributes['password']=password_hash($user->attributes['password'],PASSWORD_DEFAULT);
            }
            if (!$user->validate($data)||!$user->checkUnique()){
                $user->getErrors();
              redirect();

            }
            if ($user->update('user',$id)){
                $_SESSION['success']='Изменения сохранены';
            }
            redirect();
        }

        $user_id=$this->getRequestID();
        $user=\RedBeanPHP\R::load('user',$user_id);

        $orders = \RedBeanPHP\R::getAll("SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, `order`.`date`, `order`.`update_at`, `order`.`currency`, ROUND(SUM(`order_product`.`price`), 2) AS `sum` FROM `order`
 JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
 WHERE user_id={$user_id}
  GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id`");



        $this->setMeta('Редактирование профиля пользователя');
        $this->set(compact('user','orders'));
    }

}