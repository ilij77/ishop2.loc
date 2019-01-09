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

    public static function createAlias($table,$field,$str,$id){
        $str=self::str2url($str);
        $res=\RedBeanPHP\R::findOne($table,"$field=?",[$str]);
        if ($res){
            $str="{$str}-{$id}";
            $res=\RedBeanPHP\R::count($table,"$field=?",[$str]);
            if ($res){
                $str=self::createAlias($table,$field,$str,$id);
            }
        }
return $str;
    }

    public static function str2url($str) {
        // переводим в транслит
        $str = self::rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

    public static function rus2translit($string) {

        $converter = array(

            'а' => 'a',   'б' => 'b',   'в' => 'v',

            'г' => 'g',   'д' => 'd',   'е' => 'e',

            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

            'и' => 'i',   'й' => 'y',   'к' => 'k',

            'л' => 'l',   'м' => 'm',   'н' => 'n',

            'о' => 'o',   'п' => 'p',   'р' => 'r',

            'с' => 's',   'т' => 't',   'у' => 'u',

            'ф' => 'f',   'х' => 'h',   'ц' => 'c',

            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',

            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',



            'А' => 'A',   'Б' => 'B',   'В' => 'V',

            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',

            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',

            'И' => 'I',   'Й' => 'Y',   'К' => 'K',

            'Л' => 'L',   'М' => 'M',   'Н' => 'N',

            'О' => 'O',   'П' => 'P',   'Р' => 'R',

            'С' => 'S',   'Т' => 'T',   'У' => 'U',

            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',

            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',

            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',

            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

        );

        return strtr($string, $converter);

    }

}