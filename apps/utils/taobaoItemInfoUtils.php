<?php
namespace app\utils;


class taobaoItemInfoUtils{
    public function autoItemId($itemId,$keywords_title,$isCheckExitItemId=true,$keywords=null){
        $table= new \app\tableUtils\taobaoItemInfoUtils();
        return $table->autoItemId($itemId,$keywords_title,$isCheckExitItemId,$keywords);
    }
    
    public function getTaobaoInfoList($page = 1, $pageSize = 20, $isOr = true)
    {
        $utils =  new \app\tableUtils\taobaoItemInfoUtils();
        return $utils->getTaobaoInfoList($page,$pageSize,$isOr);
    }
    
    public function getTaobaoInfoListForTime($isOr = true)
    {
        $utils =  new \app\tableUtils\taobaoItemInfoUtils();
        return $utils->getTaobaoInfoListForTime($isOr);
    }
    
    public  function updateAskeverybodyList($data,$itemId){
        $utils =  new \app\tableUtils\taobaoItemInfoUtils();
        return $utils->updateAskeverybodyList($data,$itemId);
    }
    
    public  function updateReasonList($data,$itemId){
        $utils =  new \app\tableUtils\taobaoItemInfoUtils();
        return $utils->updateReasonList($data,$itemId);
    }
    
    public  function updateCommentList($data,$itemId){
        $utils =  new \app\tableUtils\taobaoItemInfoUtils();
        return $utils->updateCommentList($data,$itemId);
    }
    
    public  function updateTaobaoItemInfo($data,$itemId){
        $utils =  new \app\tableUtils\taobaoItemInfoUtils();
        return $utils->updateTaobaoItemInfo($data,$itemId);
    }
}