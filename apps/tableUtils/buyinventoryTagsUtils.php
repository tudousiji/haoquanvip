<?php

namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;

class buyinventoryTagsUtils{
    public function addBuyinventoryTags($data){
        return $contentId = Db::table(TableUtils::getTableDetails('buyinventory_tags'))
        ->insert($data);
    }
    
    public function getBuyinventoryTagsMd5($tagsMd5){
        $table= Db::table(TableUtils::getTableDetails('buyinventory_tags'))
        ->where(TableUtils::getTableDetails('buyinventory_tags', 'md5'),$tagsMd5);
        $data=$table->find();
        //echo $table->getLastSql();
        return $data;
    }
}