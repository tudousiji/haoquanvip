<?php
namespace app\api\model;
use app\base\BaseModel;
use app\keyWords\model;
use app\tableUtils\darenUtils;

class DaRenModel  extends BaseModel{
    public function insertDaRen($data){
        $daren=new darenUtils();
        return $daren->addDaRen($data);
    }
    
    public function getDaRen($id=0){
        $daren=new darenUtils();
        return $daren->getDaRen($id);
    }
    
    public function getDaRenList($page=1,$pageSize=20){
        $daren=new darenUtils();
        return $daren->getDaRenList($page,$pageSize);
    }
}