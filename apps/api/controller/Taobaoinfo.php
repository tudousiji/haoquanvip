<?php
namespace app\api\controller;
use app\utils\taobaoItemInfoUtils;

class Taobaoinfo{
    public function getTaobaoInfoList()
    {
        $page = isset($_REQUEST['page']) && ! empty($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $pageSize = isset($_REQUEST['pageSize']) && ! empty($_REQUEST['pageSize']) ? $_REQUEST['pageSize'] : "50";
        
        $utils= new taobaoItemInfoUtils();
        $list = $utils->getTaobaoInfoListForTime();
        $size=count($list);
        $data=[];
        for($i=0;$i<$size;$i++){
            $keyWords=[
                'status'=>empty($list[$i]['keywords'])?true:false,
                'title'=>$list[$i]['title']
            ];
            $array=[
                'itemId'=>$list[$i]['itemId'],
                'keywords'=>$keyWords,
                'reason'=>empty($list[$i]['reason'])?true:false,
                'commentList'=>empty($list[$i]['commentList'])?true:false,
                'askeverybodyList'=>empty($list[$i]['askeverybodyList'])?true:false,
                
            ];
            $data[$i]=$array;
        }
        
        echo json_encode($data);
    }
    
    
    public function addTaobaoItemInfo(){
        $json = isset($_REQUEST['data']) && !empty($_REQUEST['data']) ? $_REQUEST['data'] : "";
        if (empty($json)) {
            $array = [
                'Code' => - 1,
                'msg' => "data数据为空"
            ];
            return json_encode($array);
        }
        $data = json_decode($json, true);
        $size=count($data);
        $utils=new \app\utils\taobaoItemInfoUtils();
        for($i=0;$i<$size;$i++){
            $array=[];
            if($data[$i]['keywords']['status']){
                $array['keywords']=$data[$i]['keywords']['data'];
                if(count($data[$i]['keywords']['data'])>0){
                    $array['title']=null;
                }
            }
            if($data[$i]['reason']['status']){
                $array['reason']=$data[$i]['reason']['data'];
            }
            if($data[$i]['commentList']['status']){
                $array['commentList']=$data[$i]['commentList']['data'];
            }
            if($data[$i]['askeverybodyList']['status']){
                $array['askeverybodyList']=$data[$i]['askeverybodyList']['data'];
            }
            $array['update_time']=time();
            $array['collectCount']=array('exp', 'collectCount+1');;
            
            $itemId=$data[$i]['itemId'];
            $utils->updateTaobaoItemInfo($array, $itemId);
        }
        $array = [
            'Code' => 0,
            'msg' => "成功"
        ];
        return json_encode($array);
    }
}