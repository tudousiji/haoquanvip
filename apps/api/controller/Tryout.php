<?php
namespace app\api\controller;

use app\base\BaseController;
use think\Request;
use app\utils\TableUtils;
//淘宝试用
class Tryout extends BaseController{
    public function checkEffectiveTaobaoTryIdListUrl(){
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        $jsonObj = json_decode($json,true);
        $table =new  \app\tableUtils\tryoutUtils();
        $failCount=0;
        $successArr=array();
        for($i=0;$i<count($jsonObj);$i++){
            $itemId=$jsonObj[$i]['itemId'];
            $reportId=$jsonObj[$i]['reportId'];
            $title=$jsonObj[$i]['title'];
            $status = $table->getTryout($itemId,$reportId);
            if($status && $status!=null && is_array($status) && count($status)>0){
                $failCount++;
            }else{
                $arr=array();
                $arr=[
                    'itemId'=>$itemId,
                    'reportId'=>$reportId,
                    'title'=>$title,
                ];
                $successArr[]=$arr;
                continue;
            }
            if($failCount>=5){
                break;
            }
        }
        $arr=[
            'isNextCate'=>$failCount>=5?True:False,
            'data'=>$successArr
        ];
        echo json_encode($arr);
    }
    
    
    public function addTaobaoTry(){
        #$itemId = isset($_REQUEST['itemId']) ? $_REQUEST['itemId'] : "";
        #$reportId = isset($_REQUEST['reportId']) ? $_REQUEST['reportId'] : "";
        $json=isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json) ){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        
        $data=json_decode($json,true);
        $itemId=$data['itemId'];
        $cate=$data['cate'];
        $reportId=$data['reportId'];
        if(empty($itemId) || empty($reportId) || $itemId=="0" || $reportId=="0"){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据错误",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        
        $array=[
            'itemId'=>$itemId,
            'reportId'=>$reportId,
            'cate'=>empty($cate)?1:$cate,//1是精选的分类
            'data'=>json_encode($data['data']),
            'update_time'=>time(),
            //'keywords'=>$data['keywords'],
        ];
        
        
        //新增taobaoid等信息
        $taobaoItemInfoUtils = new \app\utils\taobaoItemInfoUtils();
        $taobaoItemInfoUtils->autoItemId($itemId,$data['data']['item']['title'],true,isset($data['keywords'])&&!empty($data['keywords'])?$data['keywords']:null);
        
        $table =new  \app\tableUtils\tryoutUtils();
        $status = $table->addTryout($array);
        if($status){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
                $jsonKeyValConfig['Code']=>0,//
            ];
            echo json_encode($data);
        }else{
            
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['Code']=>-1,//
                
            ];
            echo json_encode($data);
            
        }
    }
    
    
    public function getCateId(){
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        $table =new  \app\tableUtils\tryoutUtils();
        $cate = $table->getCate();
        
        $array=[];
        for($i=0;$i<count($cate);$i++){
            //if($cate[$i]['cate_id']>0){
                $array[]=$cate[$i]['cate_id'];
           //}
        }
        $arr=[
            $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
            $jsonKeyValConfig['Code']=>0,//
            'data'=>$array
        ];
        echo json_encode($arr);
    }
    
}