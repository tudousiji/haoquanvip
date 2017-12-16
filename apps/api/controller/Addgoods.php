<?php
namespace app\api\controller;

use app\base\BaseController;
use think\Request;

class Addgoods extends BaseController{
    public function addGoodsItem(){
        $json = isset($_REQUEST['data']) && !empty($_REQUEST['data']) ? $_REQUEST['data'] : "";
        if (empty($json)) {
            $array = [
                'Code' => - 1,
                'msg' => "data数据为空"
            ];
            return json_encode($array);
        }
        $data = json_decode($json, true);
        
        $keywords = new \app\keyWords\model\KeyWords();
        $keywords->addItemDb(false,$data['keyword_id'], $data['data']);
        
        
        $collectCountArray=[
            'collectCount'=>array('exp', 'collectCount+1'),
        ];
        $keywords = new  \app\api\model\KeyWordsModel();
        $keywords->updateKeywordCollectCount($data['keyword_id'], $collectCountArray);
        
        
        $array = [
            'Code' => 0,
            'msg' => "成功"
        ];
        return json_encode($array);
    }
}