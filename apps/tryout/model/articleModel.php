<?php
namespace app\tryout\model;
use app\base\BaseModel;
use app\tableUtils\tryoutUtils;

class articleModel extends BaseModel{
    public function getTryOut($id){
        $table = new tryoutUtils();
        return $table->getTryOutData($id);
    }
    
    public function getTryOutCate($id){
        $table = new tryoutUtils();
        return $table->getTryOutCate($id);
    }
    
    public function getTryOutCateId($cateId){
        $table = new tryoutUtils();
        return $table->getTryOutCateId($cateId);
    }
    
    public function getList($cateId,$page = 1,$pageSize=20){
        $table = new tryoutUtils();
        return $table->getList($cateId,$page,$pageSize);
    }
    
    public function getCount($cateid)
    {
        $table = new tryoutUtils();
        return $table->getCount($cateid);
    }
    
    public function getRandList($randCount=10){
        $table = new tryoutUtils();
        return $table->getRandList($randCount);
    }
    
    public function getPrveRandList($id,$randCount=10){
        $table = new tryoutUtils();
        return $table->getPrveRandList($id,$randCount);
    }
    
}