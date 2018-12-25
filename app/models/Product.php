<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 26.12.2018
 * Time: 1:06
 */

namespace app\models ;


class Product extends AppModel
{
    public function setRecentlyViewed($id)
    {
        $recetlyViewed=$this->getAllRecentlyViewed();
        if (!$recetlyViewed){
         setcookie('recentlyViewed',$id,time()+3600*24,'/');
        }else{

            $recetlyViewed=explode('.',$recetlyViewed);
            if (!in_array($id,$recetlyViewed)){
                $recetlyViewed[]=$id;
                $recetlyViewed=implode('.',$recetlyViewed);
                setcookie('recentlyViewed',$recetlyViewed,time()+3600*24,'/');
            }
            //debug($recetlyViewed);
        }



    }

    public function getRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])){
            $recentlyViewed=$_COOKIE['recentlyViewed'];
            $recentlyViewed=explode('.',$recentlyViewed);
            return array_slice($recentlyViewed,-3);
        }return false;



    }
    public function getAllRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])){
            return$_COOKIE['recentlyViewed'];
        }return false;


    }

}