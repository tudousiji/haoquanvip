<?php
namespace app\api\controller;

use app\base\BaseController;
use think\Request;


class Daren  extends BaseController{
    public function getDaRenUrl(){
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "0";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        $daRen = new \app\api\model\DaRenModel();
        $nextData = $daRen->getDaRen($id);
        //print_r ($nextData);
        if($nextData!=null){
            $nextData['data']=json_decode($nextData['data'],true);
            $array=[
                'url'=>$nextData['data']['darenUrl'],
                'userId'=>$nextData['data']['userId'],
            ];
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
                $jsonKeyValConfig['Code']=>0,//
                'data'=>$array,
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
    
    public function addDaRenUrlForList(){
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
        $successCount=0;
        for($i=0;$i<count($jsonObj);$i++){
            $array=[
                'data'=>json_encode($jsonObj[$i]) ,
                'userId'=>$jsonObj[$i]['userId'],
            ];
            $table =new  \app\tableUtils\darenUtils();
            $status = $table->addDaRen($array);
            if($status){
                $successCount++;
            }
        }
        
        if($successCount==count($jsonObj)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
                $jsonKeyValConfig['msg']=>"成功",
                $jsonKeyValConfig['Code']=>0,//
            ];
            echo json_encode($data);
        }else{
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>"插入失败",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            echo json_encode($data);
        }
        #echo $data;
    }
    
    
    public function getDaRenList(){
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $pagesize = isset($_REQUEST['pagesize']) && is_numeric($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : "20";
        $daRen = new \app\api\model\DaRenModel();
        $list = $daRen->getDaRenList($page,$pagesize);
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        $data=[
            $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
            'data'=>$list,
            $jsonKeyValConfig['Code']=>0,//
        ];
        echo json_encode($data);
    }
    
    
}