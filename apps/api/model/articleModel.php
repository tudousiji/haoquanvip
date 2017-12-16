<?php
namespace app\api\model;
use app\base\BaseModel;
use app\keyWords\model;
use app\tableUtils\articleContentidUtils;


class articleModel  extends BaseModel
{
    /**
     * 检测重复ContentId
     */
    public function checkRepeatContentId($ids){
        $utils=new articleContentidUtils();
        
        return $utils->checkRepeatContentId($ids);
    }
    
    /**
     * 添加ContentId
     */
    public function addContentId($data){
        $utils=new articleContentidUtils();
        return $utils->addContentId($data);
    }
    
    
    
}

