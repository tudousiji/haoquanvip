<?php
namespace app\tryout\controller;

use app\base\BaseController;
use app\tryout\model\articleModel;

require_once 'apps/utils/function.php';

class Articlecontroller extends BaseController
{

    public function lists()
    {
        $cateId = isset($_REQUEST['cateId']) && is_numeric($_REQUEST['cateId']) ? $_REQUEST['cateId'] : "0";
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $articleModel = new articleModel();
        
        $cate = $articleModel->getTryOutCate($cateId);
        $list = $articleModel->getList($cate['cate_id'], $page);
        $count = $articleModel->getCount($cate['cate_id']);
        
        $randTryList=$articleModel->getRandList(10);
        for ($i = 0; $i < count($randTryList); $i ++) {
            $randTryList[$i]['data'] = json_decode($randTryList[$i]['data'], true);
            $randTryList[$i]['introduction'] = "";
            if (isset($randTryList[$i]['data']['overall']['content'])) {
                $randTryList[$i]['introduction'] = $randTryList[$i]['data']['overall']['content'];
            }
            if ($i == 0) {
                if (strlen($randTryList[$i]['introduction']) < 650) {
                    if (isset($randTryList[$i]['data']['highlight']) && is_array($randTryList[$i]['data']['highlight']) && count($randTryList[$i]['data']['highlight']) > 0) {
                        $size = count($randTryList[$i]['data']['highlight']);
                        for ($j = 0; $j < $size; $j ++) {
                            $randTryList[$i]['introduction'] .= $randTryList[$i]['data']['highlight'][$j]['content'];
                            if (strlen($randTryList[$i]['introduction']) >= 650) {
                                break;
                            }
                        }
                    }
                }
                if (strlen($randTryList[$i]['introduction']) < 650) {
                    if (isset($randTryList[$i]['data']['conclusion']['cons'])) {
                        $randTryList[$i]['introduction'] .= $randTryList[$i]['data']['conclusion']['cons'];
                    }
                } else {
                    continue;
                }
                if (strlen($randTryList[$i]['introduction']) < 650) {
                    if (isset($randTryList[$i]['data']['conclusion']['pros'])) {
                        $randTryList[$i]['introduction'] .= $randTryList[$i]['data']['conclusion']['pros'];
                    }
                } else {
                    continue;
                }
            }
        }
        
        $KeyWordsModel = new \app\keywords\model\KeyWords(); // 
        $randGoodsList = $KeyWordsModel->getRandList(10); // 随机10个商品
        //print_r($randGoodsList);
        for ($i = 0; $i < count($list); $i ++) {
            $list[$i]['data'] = json_decode($list[$i]['data'], true);
            
            $list[$i]['introduction'] = "";
            if (isset($list[$i]['data']['overall']['content'])) {
                $list[$i]['introduction'] = $list[$i]['data']['overall']['content'];
            }
            $isLenMax = false;
            if (strlen($list[$i]['introduction']) < 650) {
                if (isset($list[$i]['data']['highlight']) && is_array($list[$i]['data']['highlight']) && count($list[$i]['data']['highlight']) > 0) {
                    $size = count($list[$i]['data']['highlight']);
                    for ($j = 0; $j < $size; $j ++) {
                        $list[$i]['introduction'] .= $list[$i]['data']['highlight'][$j]['content'];
                        if (strlen($list[$i]['introduction']) >= 650) {
                            break;
                        }
                    }
                }
            }
            if (strlen($list[$i]['introduction']) < 650) {
                if (isset($list[$i]['data']['conclusion']['cons'])) {
                    $list[$i]['introduction'] .= $list[$i]['data']['conclusion']['cons'];
                }
            } else {
                continue;
            }
            if (strlen($list[$i]['introduction']) < 650) {
                if (isset($list[$i]['data']['conclusion']['pros'])) {
                    $list[$i]['introduction'] .= $list[$i]['data']['conclusion']['pros'];
                }
            } else {
                continue;
            }
            if (strlen($list[$i]['introduction']) < 650) {
                if (isset($list[$i]['data']['experience']) && is_array($list[$i]['data']['experience']) && count($list[$i]['data']['experience']) > 0) {
                    $size = count($list[$i]['data']['experience']);
                    for ($j = 0; $j < $size; $j ++) {
                        $list[$i]['introduction'] .= $list[$i]['data']['experience'][$j]['content'];
                        if (strlen($list[$i]['introduction']) >= 650) {
                            break;
                        }
                    }
                }
            }
        }
        
        $this->assign('randGoodsList', $randGoodsList);
        $this->assign('randTryList', $randTryList);
        $this->assign('pageList', page($page, $count));
        $this->assign('page', $page);
        $this->assign('cate', $cate);
        $this->assign('list', $list);
        $this->assign('cateId', $cateId);
        $this->assign('count', $count);
        return $this->fetch('list');
    }

    public function item()
    {
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "0";
        $articleModel = new articleModel();
        $data = $articleModel->getTryOut($id);
        $data['data']=json_decode($data['data'],true);
        
        if(empty($data['taobao_item_info_itemId'])){//往淘宝信息库里面插入itemid
            $utils=new \app\utils\taobaoItemInfoUtils();
            $utils->autoItemId($data['itemId'],$data['data']['item']['title'],true);
        }
        
        $content = $data['data'];
        $keyWordsArr= json_decode($data['keywords'], true);
        $cate = $articleModel->getTryOutCateId($data['cate']);
        $keyWords="";
        $size=count($keyWordsArr);
        for($i=0;$i<$size;$i++){
            $keyWords.=$keyWordsArr[$i];
            if($i!=$size-1){
                $keyWords.=",";
            }
        };
        $this->assign("description", $this->addHandleIntroduction($content));
        $this->assign("keyWords", $keyWords);
        $this->assign("cate", $cate);
        $this->assign("item", $content);
        return $this->fetch("item");
    }
    
    public function addHandleIntroduction($data,$introductionLen=650){
        $data=$this->getIntroduction($data,$introductionLen);
        if(!empty($data)){
            $data.="...";
        }
        return $data;
    }
    
    public function getIntroduction($data,$introductionLen=650){
        $introduction = "";
        if (isset($data['overall']['content'])) {
            $introduction = $data['overall']['content'];
        }
        $isLenMax = false;
        if (strlen($introduction) < $introductionLen) {
            if (isset($data['highlight']) && is_array($data['highlight']) && count($data['highlight']) > 0) {
                $size = count($data['highlight']);
                for ($j = 0; $j < $size; $j ++) {
                    $introduction .= $data['highlight'][$j]['content'];
                    if (strlen($introduction) >= $introductionLen) {
                        return $introduction;
                    }
                }
            }
        }
        if (strlen($introduction) < $introductionLen) {
            if (isset($data['conclusion']['cons'])) {
                $introduction .= $data['conclusion']['cons'];
            }
        } else {
            return $introduction;
        }
        if (strlen($introduction) < $introductionLen) {
            if (isset($data['conclusion']['pros'])) {
                $introduction .= $data['conclusion']['pros'];
            }
        } else {
            return $introduction;
        }
        if (strlen($introduction) < $introductionLen) {
            if (isset($data['experience']) && is_array($data['experience']) && count($data['experience']) > 0) {
                $size = count($data['experience']);
                for ($j = 0; $j < $size; $j ++) {
                    $introduction .= $data['experience'][$j]['content'];
                    if (strlen($introduction) >= $introductionLen) {
                        return $introduction;
                    }
                }
            }
        }
    }
    
}

?>