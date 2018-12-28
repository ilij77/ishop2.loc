<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.12.2018
 * Time: 16:49
 */

namespace app\models;


use ishop\base\Model;
use Valitron\Validator;

class AppModel extends Model
{
    public function load($data){
        foreach($this->attributes as $name => $value){
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function save($table){
        $tbl=\RedBeanPHP\R::dispense($table);
        foreach ($this->attributes as $name=>$value ){
            $tbl->$name=$value;
        }
        //return debug($tbl);
        return \RedBeanPHP\R::store($tbl);

    }


    public function validate($data){
        Validator::langDir(WWW.'/validator/lang');
        Validator::lang('ru');
        $v=new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()){
            return true;
        }
        $this->errors=$v->errors();
        return false;
    }
    public function getErrors(){
        $errors='<ul>';
        foreach ($this->errors as $error){
            foreach ($error as $item){
                $errors.='<li>'.$item.'</li>';
            }
        }
        $errors.='</ul>';
        $_SESSION['error']=$errors;
    }

}