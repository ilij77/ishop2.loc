<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 30.12.2018
 * Time: 0:32
 */

namespace app\widgets\filter;


use ishop\Cashe;

class Filter
{
    public $groups;
    public $attrs;
    public $tpl;

    public function __construct()
    {
        $this->tpl=__DIR__.'/filter_tpl.php';
        $this->run();

    }

    protected function run(){
        $cache=Cashe::instance();
        $this->groups=$cache->get('filter_group');
        if (!$this->groups){
            $this->groups=$this->getGroups();
            $cache->set('filter_group',$this->groups,1);

        }
        $this->attrs=$cache->get('filter_attrs');
        if (!$this->attrs){
            $this->attrs=$this->getAttrs();
            $cache->set('filter_attrs',$this->attrs,1);
                    }
        $filters=$this->getHtml();
        echo $filters;
    }

    protected function getHtml(){
        ob_start();
        require $this->tpl;
        return ob_get_clean();

    }

    protected function  getGroups(){
        return \RedBeanPHP\R::getAssoc('SELECT id,title FROM attribute_group');
    }

    protected function  getAttrs(){
        $data=\RedBeanPHP\R::getAssoc('SELECT * FROM attribute_value');
        $attrs=[];
        foreach ($data as $k=>$v){
            $attrs[$v['attr_group_id']][$k]=$v['value'];
        }
        return $attrs;
    }

}