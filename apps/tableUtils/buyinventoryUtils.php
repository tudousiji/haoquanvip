<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;

class buyinventoryUtils{
    public function getCateList(){
        return Db::table(TableUtils::getTableDetails('buyinventory_cate'))->order(TableUtils::getTableDetails('buyinventory_cate', 'id'),"asc")
        ->select();
    }
    
    public function getCateId($cateId){
        return Db::table(TableUtils::getTableDetails('buyinventory_cate'))->where(TableUtils::getTableDetails('buyinventory_cate', 'id'),$cateId)
        ->find();
    }
    
    public function checkEffectiveContentIdList($contentId){
        $table= Db::table(TableUtils::getTableDetails('buyinventory_item_info'))->
        where(TableUtils::getTableDetails('buyinventory_item_info', 'contentId'),"in",$contentId) 
        ->order(TableUtils::getTableDetails('buyinventory_item_info', 'id'),"asc")
        ->column(TableUtils::getTableDetails('buyinventory_item_info', 'contentId'))
        ;
        //$data=$table->select();
        //echo $table->getLastSql();
        return $table;
    }
    
    public function getItemForContentId($contentId){
        return Db::table(TableUtils::getTableDetails('buyinventory_item_info'))
        ->where(TableUtils::getTableDetails('buyinventory_item_info', 'contentId'),$contentId)
        ->find();
    }
    
    public function addbuyInventoryItem($data){
        return $keywords_details = Db::table(TableUtils::getTableDetails('buyinventory_item_info'))
        ->insert($data);
    }
    
    /**
     * 获取未采集的ContentId
     */
    public function getContentIdList(){
        return Db::table(TableUtils::getTableDetails('article_contentid'))
        ->where(TableUtils::getTableDetails('article_contentid', 'status'),0)
        ->order("collectCount asc,update_time asc,".TableUtils::getTableDetails('buyinventory_cate', 'id')." asc")
        ->limit(50)
        ->select();
    }
    
    /**
     * 更新ContentId状态
     * @param unknown $contentId
     * @param number $status
     * @return number
     */
    public function updateContentIdStatus($contentId,$status=1){
        $data=[
            'status'=>$status,
            'collectCount'=>array('exp', 'collectCount+1'),
            'update_time'=>time(),
        ];
        return Db::table(TableUtils::getTableDetails('article_contentid'))->where(
            TableUtils::getTableDetails('article_contentid', 'contentId'), $contentId)
            ->setField($data);
    }
    
    
    /**
     * 添加buyinventory_item_info
     */
    /* public function addBuyinventoryItem($data){
        return $contentId = Db::table(TableUtils::getTableDetails('buyinventory_item_info'))
        ->insert($data);
    } */
    
    
    public function getItemLists($cateId,$page=1,$pageSize=20){
        $table= Db::table(TableUtils::getTableDetails('buyinventory_item_info'))
        ->order(TableUtils::getTableDetails('buyinventory_item_info', 'id'),"desc")
        ->where(TableUtils::getTableDetails('buyinventory_item_info', 'cate_id'),$cateId)
        ->limit(($page-1)*$pageSize,$pageSize);
        $data=$table->select();
        //echo $table->getLastSql();
        return $data;
    }
    
    
    public function getItem($id){
        $table= Db::table(TableUtils::getTableDetails('buyinventory_item_info'))
        ->where(TableUtils::getTableDetails('buyinventory_item_info', 'id'),$id);
        $data=$table->find();
        //echo $table->getLastSql();
        return $data;
    }


    public function getCate($cateId){
        $table= Db::table(TableUtils::getTableDetails('buyinventory_cate'))
            ->where(TableUtils::getTableDetails('buyinventory_cate', 'id'),$cateId);
        $data=$table->find();
        //echo $table->getLastSql();
        return $data;
    }

    public function getCount($cateId){
        $tableObg = Db::table(TableUtils::getTableDetails('buyinventory_item_info'));

        if(is_numeric($cateId)){
            $tableObg->where(TableUtils::getTableDetails('buyinventory_item_info', 'cate_id'), $cateId);
        }
        $count=$tableObg->count();
        return $count;
    }
}