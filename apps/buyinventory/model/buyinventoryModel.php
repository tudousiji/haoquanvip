<?php
namespace app\buyinventory\model;


use app\base\BaseModel;
use app\tableUtils\buyinventoryUtils;


class buyinventoryModel  extends BaseModel{
    public function getItemLists($cateId,$page,$pageSize=20){
        $table = new buyinventoryUtils();
        return $table->getItemLists($cateId,$page,$pageSize);
    }
    
    public function getItem($id){
        $table = new buyinventoryUtils();
        return $table->getItem($id);
    }


    public function getCate($cateId){
        $table = new buyinventoryUtils();
        return $table->getCate($cateId);
    }

    public function getCount($cateId){
    $table = new buyinventoryUtils();
    return $table->getCount($cateId);
}

}