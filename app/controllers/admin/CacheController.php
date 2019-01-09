<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 09.01.2019
 * Time: 18:27
 */

namespace app\controllers\admin;


use ishop\Cashe;

class CacheController extends AppController
{
    public function indexAction(){


        $this->setMeta('Очистка кеша');

    }

    public function deleteAction(){
       $key=isset($_GET['key'])?$_GET['key']:null;
       $cache=Cashe::instance();
       switch ($key){
           case 'category':
               $cache->delete('cats');
               $cache->delete('ishop_menu');
                 break;
           case 'filter':
               $cache->delete('filter_group');
               $cache->delete('filter_attrs');
               break;
       }
       $_SESSION['success']='Выбранный кэш удален';
       redirect();
    }

}