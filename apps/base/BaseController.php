<?php
namespace app\base;

use think\Controller;

class BaseController extends \think\Controller
{
    protected $keyConfig;
    
    public function __construct(){
        parent::__construct();
        if ($this->keyConfig == null) {
            $this->keyConfig = require ('apps/config/keyConfig.php');
            // var_dump($this->table);
        }
        $this->assign("title",$this->keyConfig['title']);
        $this->assign("subtitle",$this->keyConfig['subtitle']);
        $this->assign("description",$this->keyConfig['description']);
        $this->assign("keyWords",$this->keyConfig['keyWords']); 
        $this->assign("taobao_img_url",$this->keyConfig['taobao_img_url']);
        $this->assign("host",$this->keyConfig['host']);
        $this->assign("img_size",$this->keyConfig['img_size']);
        $this->indexCate();
        $this->randHeaderHotSearchWord();
        $this->getTryCateList();
        $this->buyinventoryCate();
    }
    
    private function indexCate(){
        $tableUtils = new \app\tableUtils\indexcateUtils();
        $list = $tableUtils->getAll();
        $this->assign("indexCate",$list);
    }

    private function buyinventoryCate(){
        $tableUtils = new \app\tableUtils\buyinventoryUtils();
        $list = $tableUtils->getCateList();
        $this->assign("buyinventoryCate",$list);
    }

    
    private function randHeaderHotSearchWord(){
        $tableUtils = new \app\tableUtils\keywordsUtils();
        $list = $tableUtils->getRandHotSearchWord();
        $this->assign("randHeaderHotSearchWord",$list);
    }
    
    private function getTryCateList(){
        $tableUtils = new \app\tableUtils\tryoutUtils();
        $list = $tableUtils->getCate();
        
        $this->assign("headerTryCate",$list);
    }
    
}

?>