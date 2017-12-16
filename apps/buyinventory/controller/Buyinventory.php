<?php

namespace app\buyinventory\controller;
use app\base\BaseController;
use app\buyinventory\model\buyinventoryModel;
require_once 'apps/utils/function.php';

class Buyinventory extends BaseController{
    public function lists(){
        $cateId = isset($_REQUEST['cateId']) && is_numeric($_REQUEST['cateId']) ? $_REQUEST['cateId'] : "0";
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : "1";
        $pageSize = isset($_REQUEST['pageSize']) && is_numeric($_REQUEST['pageSize']) ? $_REQUEST['pageSize'] : "20";
        $utils=new buyinventoryModel();
        $list = $utils->getItemLists($cateId, $page,$pageSize);

        $cate = $utils->getCate($cateId);


        $count = $utils->getCount($cateId);

        $this->assign('pageList', page($page, $count));
        $this->assign("cate",$cate);
        $this->assign("cateId",$cateId);
        $this->assign("page",$page);
        $this->assign("list",$list);
        $this->assign("count",$count);
        return $this->fetch("list");
    }
    
    
    public function item(){
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "1";
        
        $utils=new buyinventoryModel();
        $item = $utils->getItem($id);
        if(!empty($item["richText"]) && $item["type"]==1){
            $item["richText"]=json_decode($item['richText'],true);
            $size=count($item["richText"]);
            for($i=0;$i<$size;$i++){
                if(isset($item["richText"][$i]["picture"]) && !empty($item["richText"][$i]["picture"])){
                    if(isset($item["richText"][$i]["picture"]["picWidth"]) && !empty($item["richText"][$i]["picture"]["picWidth"]) && $item["richText"][$i]["picture"]["picWidth"]>850){
                        $fl=$item["richText"][$i]["picture"]["picWidth"]/850;

                        $item["richText"][$i]["picture"]["picHeight"]=$item["richText"][$i]["picture"]["picHeight"]/$fl;
                        //if(isset($item["richText"][$i]["picture"]["picWidth"]) && !empty($item["richText"][$i]["picture"]["picWidth"]) && $item["richText"][$i]["picture"]["picWidth"]>1184){
                        $item["richText"][$i]["picture"]["picWidth"]=$item["richText"][$i]["picture"]["picWidth"]/$fl;
                        //}
                    }

                }
            }
        }else if(!empty($item["modules"]) && $item["type"]==2){
            $item["modules"]=json_decode($item['modules'],true);
        }elseif(!empty($item["products"]) && $item["type"]==3){
            $item["products"]=json_decode($item['products'],true);
        }


        //$item["data"]=json_decode($item['data'],true);
        $cate = $utils->getCate($item["cate_id"]);
        $this->assign("cate",$cate);
        $this->assign("title",$item["title"]);
        $this->assign("item",$item);
        return $this->fetch("item");
    }

    /*
     * 获取视频ajax请求html
     */
    public function getVideoHtml(){
        $id = isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "1";
        $utils=new buyinventoryModel();
        $item = $utils->getItem($id);
        if(!empty($item["products"]) && $item["type"]==3){
            $item["products"]=json_decode($item['products'],true);
        }
        if($item["type"]!=3){
            echo "";
            return;
        }
        $this->assign("item",$item);

        return $this->fetch("videoAjax");
    }
}