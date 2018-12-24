<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 20.12.2018
 * Time: 1:23
 */

namespace ishop;


class Cashe
{
    use TSingleton;

    public function set($key,$data,$seconds=3600)
    {
        if ($seconds){
            $content['data']=$data;
            $content['end_time']=time()+$seconds;
            if (file_put_contents(CASHE . '/' .md5($key).'.txt',serialize($content))){
               return true;
            }

        }
        return false;

    }

    public function get($key)
    {
        $file=CASHE.'/'. md5($key).'.txt';
        if (file_exists($file)){
            $content=unserialize(file_get_contents($file));
            if(time()<=$content['end_time']){
                return $content['data'];
            }
            unlink($file);
        }
        return false;

    }

    public function delete($key)
    {
        $file=CASHE.'/'. md5($key).'.txt';
        if (file_exists($file)){
            unlink($file);
        }


    }

}