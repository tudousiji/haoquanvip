<?php
namespace app\api\controller;
use think\Db;
use app\utils\TableUtils;
use app\base\BaseController;

class Proxyip extends BaseController{
    public function getAllList(){
        $list = Db::table(TableUtils::getTableDetails('proxy_ip'))->where(TableUtils::getTableDetails('proxy_ip','status'),0)->select(); // 
        echo json_encode($list);
    }
    //已测试
    public function getNextProxyIpList(){
        $id = isset($_REQUEST['id']) && ! empty($_REQUEST['id']) ? $_REQUEST['id'] : "1";
        $page = isset($_REQUEST['page']) && ! empty($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $pageSize = isset($_REQUEST['pageSize']) && ! empty($_REQUEST['pageSize']) ? $_REQUEST['pageSize'] : "50";
        $list = Db::table(TableUtils::getTableDetails('proxy_ip'))->limit(($page-1)*$pageSize,$pageSize)->select();
       /*  $ProxyIp = Db::table(TableUtils::getTableDetails('proxy_ip'))->where(TableUtils::getTableDetails('proxy_ip','id'),'>',$id)
        ->where(TableUtils::getTableDetails('proxy_ip','status'),0)
        ->order(TableUtils::getTableDetails('proxy_ip','>','id').' desc')->limit(1)->find(); //  */
        if($list && !empty($list) && is_array($list) 
            && count($list)>0){
            $array=[
                'Code'=>0,
                'data'=>$list,
                'Status'=>'Success',
            ];
            echo json_encode($array);
        }else{
            $data=[
                $jsonKeyValConfig['msg']=>"数据错误",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            echo json_encode($data);
        }
        
    }
    
    public function updateFailProxyIp(){
        $json = isset($_REQUEST['data']) && ! empty($_REQUEST['data']) ? $_REQUEST['data'] : "";
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
        
        if($jsonObj && $jsonObj!=null){
            $successCount=0;
            for($i=0;$i<count($jsonObj);$i++){
                $array=[
                    'status'=>1,
                    'update_time'=>time(),
                ];
                $table =new  \app\tableUtils\proxyipUtils();
                $status = $table->updateFailProxtIp($array,$jsonObj[$i]['id']);
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
        }else{
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>"数据解析错误",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            echo json_encode($data);
            return ;
        }
    }
    
    public function setProxyIpStatus(){
        $id = isset($_REQUEST['id']) && ! empty($_REQUEST['id']) ? $_REQUEST['id'] : "";
        $status = isset($_REQUEST['status']) && ! empty($_REQUEST['status']) ? $_REQUEST['status'] : "";
        $jsonKeyValConfig=require_once 'apps/utils/jsonKeyValConfig.php';
        if(empty($id) || empty($status)){
            $data=[
                $jsonKeyValConfig['msg']=>$jsonKeyValConfig['msg'].":id,status",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            echo json_encode($data);
            return ;
        }
        $data=[
            TableUtils::getTableDetails('proxy_ip','status')=>$status,
        ];
        $update = Db::table(TableUtils::getTableDetails('proxy_ip'))->where(TableUtils::getTableDetails('id','id'),$id)->update($data);
        if($update){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
                $jsonKeyValConfig['msg']=>"成功",
                $jsonKeyValConfig['Code']=>0,//
            ];
            echo json_encode($data);
        }else{
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>$jsonKeyValConfig['msg'].":更新失败",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            echo json_encode($data);
        }
    }
    
    
    //添加代理ip  已测试
    public function addProxyIp(){
        $json = isset($_REQUEST['data']) && ! empty($_REQUEST['data']) ? $_REQUEST['data'] : "";
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
        
        if($jsonObj && $jsonObj!=null){
            $successCount=0;
            for($i=0;$i<count($jsonObj);$i++){
                $array=[
                    'ip'=>$jsonObj[$i]['ip'],
                    'port'=>$jsonObj[$i]['port'],
                    'http_type'=>$jsonObj[$i]['type'],
                    'status'=>0,
                    'log'=>'',
                    'update_time'=>time(),
                ];
                $table =new  \app\tableUtils\proxyipUtils();
                $status = $table->addProxtIp($array);
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
        }else{
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>"数据解析错误",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            echo json_encode($data);
            return ;
        }
        
    }
    
}

?>