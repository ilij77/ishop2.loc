<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 31.12.2018
 * Time: 19:29
 */

namespace app\controllers\admin;


use ishop\libs\Pagination;

class OrderController extends AppController
{
    public function indexAction(){
        $page=isset($_GET['page'])? (int)$_GET['page']: 1;

        $perpage=1;
        $count=\RedBeanPHP\R::count('order');
        $pagination=new Pagination($page,$perpage,$count);
        $start=$pagination->getStart();
        //debug($start);
        $orders = \RedBeanPHP\R::getAll("SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, `order`.`date`, `order`.`update_at`, `order`.`currency`, `user`.`name`, ROUND(SUM(`order_product`.`price`), 2) AS `sum` FROM `order`
  JOIN `user` ON `order`.`user_id` = `user`.`id`
  JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
  GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id` LIMIT $start, $perpage");
//debug($orders);

$this->setMeta('Список заказов');
$this->set(compact('orders','pagination','count'));
    }

}