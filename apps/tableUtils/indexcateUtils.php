<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;

class indexcateUtils{
    public function getAll($status=0){
        return Db::table(TableUtils::getTableDetails('index_cate'))->where(
            TableUtils::getTableDetails('index_cate', 'status'), $status)
            ->select();
    }
    
    public function getIndexCateForId($id=0){
        return Db::table(TableUtils::getTableDetails('index_cate'))->where(
            TableUtils::getTableDetails('index_cate', 'id'), $id)
            ->find();
    }
}
?>