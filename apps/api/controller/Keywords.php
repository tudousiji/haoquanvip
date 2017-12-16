<?php
namespace app\api\controller;

use app\base\BaseController;
use think\Request;
use app\api\model\KeyWordsModel;

// require_once 'apps/utils/function.php';
class Keywords extends BaseController
{

    public function keywordsId()
    {
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "0";
        $time = isset($_REQUEST['time']) && is_numeric($_REQUEST['time']) ? $_REQUEST['time'] : "";
        $sign = isset($_REQUEST['sign']) && ! isEmpty($_REQUEST['sign']) ? $_REQUEST['sign'] : "";
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        // var_dump(input('id'));
        
        $jsonKeyValConfig = require_once 'apps/config/jsonKeyValConfig.php';
        
        $isCollection = true;
        if (! empty($time) && ! empty($sign) && md5($time) == $sign) {
            $pageSize = 1000;
            $isCollection = true;
        } else {
            $data = [
                $jsonKeyValConfig['msg'] => $jsonKeyValConfig['sign_error'],
                'code' => - 1 //
            ];
            // echo json_encode($data);
            // return;
        }
        
        $keywords = new \app\api\model\KeyWordsModel();
        $return = $keywords->getData($id, $page, $isCollection);
        
        if ($keywords != null) {
            $nextData = $keywords->getNextData($return);
            if (! empty($nextData) && is_array($nextData)) {
                $data = [
                    $jsonKeyValConfig['Status'] => $jsonKeyValConfig['Success'],
                    $jsonKeyValConfig['Code'] => 0, //
                    'data' => $nextData
                ];
                echo json_encode($data);
            } else {
                $data = [
                    $jsonKeyValConfig['Status'] => $jsonKeyValConfig['Fail'],
                    $jsonKeyValConfig['Code'] => - 1 //
                
                ];
                echo json_encode($data);
            }
        } else {
            $data = [
                $jsonKeyValConfig['Status'] => $jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['Code'] => - 1 //
            
            ];
            echo json_encode($data);
        }
    }

    // 查询大于传入id的数据，用于采集 问大家，评论，和评论数，和 推荐理由
    public function getItem($id = 0)
    {
        // $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "0";
        $tableUtils = new \app\tableUtils\goodslistUtils();
        $item = $tableUtils->getItemForGtId($id);
        if ($item != null) {
            $array = [
                'Code' => 0,
                'data' => $item
            ];
            return json_encode($array);
        } else {
            $array = [
                'Code' => - 1,
                'msg' => "数据为空"
            ];
            return json_encode($array);
        }
    }

    // id 要更新的id 并返回下一个商品信息
    public function upDateGoodsItem()
    {
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "0";
        if ($id == 0) {
            getItem($id);
            return;
        }
        $json = isset($_REQUEST['data']) && is_numeric($_REQUEST['data']) ? $_REQUEST['data'] : "";
        if (empty($json)) {
            $array = [
                'Code' => - 1,
                'msg' => "data数据为空"
            ];
            return json_encode($array);
        }
        
        $data = json_decode($json, true);
        if (! $data || empty($data) || ! is_array($data) || count($data) <= 0) {
            $array = [
                'Code' => - 1,
                'msg' => "data数据为空"
            ];
            return json_encode($array);
        }
        /*
         * $array=[
         * 'field'=>'reason',//reason commentList askeverybodyList
         * 'id'=>'id',
         * 'json'=>"",
         * ];
         */
        $array = [
            'reason',
            'commentList',
            'askeverybodyList'
        ];
        if (! in_array($array, $data['field'])) {
            $array = [
                'Code' => - 1,
                'msg' => "数据错误"
            ];
            return json_encode($array);
        }
        
        $data = [
            $data['field'] => $data['json']
        ];
        $tableUtils = new \app\tableUtils\goodslistUtils();
        $tableUtils->updateItem($id, $data);
        getItem($id);
    }

    // 热门关键词
    public function addHotKeyWords()
    {
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig = require_once 'apps/config/jsonKeyValConfig.php';
        
        if (empty($json)) {
            $array = [
                'Code' => - 1,
                'msg' => "data数据为空"
            ];
            return json_encode($array);
        }
        $data = json_decode($json, true);
        $repeatCount=0;
        for ($i = 0; $i < count($data); $i ++) {
            $model = new KeyWordsModel();
            $kwMd5=md5($data[$i]);
            $findData = $model->findHotKeyWordsMd5($kwMd5);
            if ($findData != null && is_array($findData) && count($findData) > 0) {
                $repeatCount++;
            } else {
                $array = [
                    'keyword' => $data[$i],
                    'update_time' => time(),
                    'kw_md5'=>$kwMd5,
                    
                ];
                
                $model->addHotKeyWords($array);
            }
        }
        $data = [
            $jsonKeyValConfig['Status'] => $jsonKeyValConfig['Success'],
            $jsonKeyValConfig['msg'] => $repeatCount==0?"成功":"成功部分，有重复:".$repeatCount."个",
            $jsonKeyValConfig['Code'] => 0 //
        ];
        echo json_encode($data);
    }
    
    /*
     * 获取关键词列表
     */
    public function getKeyWordsList(){
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $pageSize = isset($_REQUEST['pageSize']) && is_numeric($_REQUEST['pageSize']) ? $_REQUEST['pageSize'] : "50";
        $model = new KeyWordsModel();
        $list = $model->getKeyWordsList($page,$pageSize);
        echo json_encode($list);
    }
    
    
    /*
     * 获取关键词的衍生关键词为空的列表
     */
    public function getKeyWordsForSubKeyWordsNullList(){
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $pageSize = isset($_REQUEST['pageSize']) && is_numeric($_REQUEST['pageSize']) ? $_REQUEST['pageSize'] : "50";
        $model = new KeyWordsModel();
        $list = $model->getKeyWordsForSubKeyWordsNullList($page,$pageSize);
        echo json_encode($list);
    }
    
    /*
     * 设置关键词衍生词为空的关键词
     */
    public function addKeyWordsForSubKeyWordsNull(){
        $json = isset($_REQUEST['data']) && !empty($_REQUEST['data']) ? $_REQUEST['data'] : "";
        if (empty($json)) {
            $array = [
                'Code' => - 1,
                'msg' => "data数据为空"
            ];
            return json_encode($array);
        }
        $data = json_decode($json, true);
        if(count($data['data']['result'])>0){
            $array=[
                'subKeyWords'=>json_encode($data['data']['result']),
                'subKeyWordsCount'=>array('exp', 'subKeyWordsCount+1')
            ];
            $model = new KeyWordsModel();
            $model->updateSubKeyWords($data['id'], $array);
            $array = [
                'Code' => 0,
                'msg' => "成功"
            ];
            return json_encode($array);
        }else{
            $array = [
                'Code' => -1,
                'msg' => "数据为空"
            ];
            return json_encode($array);
        }
        
    }
}

?>
