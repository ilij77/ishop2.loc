<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 29.12.2018
 * Time: 4:54
 */

namespace app\models;


class Order extends AppModel
{
    public static function saveOrder($data)
    {
        $order = \RedBeanPHP\R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = \RedBeanPHP\R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }

    public static function saveOrderProduct($order_id){
        $sql_part='';
        foreach ($_SESSION['cart'] as $product_id=>$product){
            $product_id=(int)$product_id;
            $sql_part.="($order_id,$product_id,{$product['qty']},'{$product['title']}',{$product['price']}),";
        }
        $sql_part=rtrim($sql_part,',');
        \RedBeanPHP\R::exec("INSERT INTO order_product(order_id, product_id, qty, title, price)VALUES  $sql_part");



    }

    public static function mailOrder($orler_id,$user_email){

    }

}