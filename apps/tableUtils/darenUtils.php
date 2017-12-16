<?php

namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;


class darenUtils{
    public static function addDaRen($data){
        return $keywords_details = Db::table(TableUtils::getTableDetails('daren'))
        ->insert($data);
    }
    
    public function getDaRen($id=0){
        return Db::table(TableUtils::getTableDetails('daren'))->
        where(TableUtils::getTableDetails('daren', 'id'),'>', $id)->order(TableUtils::getTableDetails('daren', 'id'),"asc")
        ->find();
    }
    
    public function getDaRenList($page=1,$pageSize=20){
        return Db::table(TableUtils::getTableDetails('daren'))->order(TableUtils::getTableDetails('daren', 'id'),"asc")
        ->limit(($page-1)*$pageSize,$pageSize)->select();
    }
}