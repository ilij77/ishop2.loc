<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 24.12.2018
 * Time: 1:23
 */

namespace app\widgets\menu;


use ishop\App;
use ishop\Cashe;

class Menu
{
    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;
    protected $container = 'ul';
    protected $class = 'menu';
    protected $table = 'category';
    protected $cache = 3600;
    protected $cacheKey = 'ishop_menu';
    protected $attrs = [];
    protected $prepend = '';

    public function __construct($options=[])
    {
        $this->tpl=__DIR__.'/menu/menu.php';
        $this->getOptions($options);

        $this->run();


    }

    protected function getOptions($options)
    {
        foreach ($options as $k=>$v){
            if (property_exists($this,$k)){
                $this->$k=$v;
            }
        }

    }
    protected function run()
    {
        $cache=Cashe::instance();
        $this->menuHtml=$cache->get($this->cacheKey);
        if (!$this->menuHtml){

            $this->data=App::$app->getProperty('cats');
            if (!$this->data){
                $this->data=$cats=\RedBeanPHP\R::getAssoc("SELECT*FROM {$this->table}");
            }

            $this->tree=$this->getTree();
            //debug($this->tree);
            $this->menuHtml=$this->getMenuHtml($this->tree);
            if (!$this->cache){
                $cache->set($this->cacheKey,$this->menuHtml,$this->cache);
            }

        }$this->output();

    }

    protected function output(){
        $attrs='';
        if (!empty($attrs)){
            foreach ($this->attrs as $k=>$v){
                $attrs.="$k='$v'";
            }
        }

        echo "<{$this->container} class='{$this->class}'$attrs>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }


    protected function  getTree()
    {
        $tree=[];
        $data=$this->data;
        foreach ($data as $id=>&$node){
            if (!$node['parent_id']){
                $tree[$id]=&$node;
            }else{
                $data[$node['parent_id']]['childs'][$id]=&$node;
            }

        }
        return $tree;

    }
    protected function getMenuHtml($tree,$tab='')
    {
        $str='';
        foreach ($tree as $id=>$category){
            $str .=$this->catToTemplate($category,$tab,$id);
        }
        return $str;

    }

    protected function catToTemplate($category,$tab,$id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();

    }

}