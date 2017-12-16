<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;


class goodslistUtils{
    
    
    public function getItem($itemId){
        return Db::table(TableUtils::getTableDetails('goods_list'))->where(
            TableUtils::getTableDetails('goods_list', 'itemId'), $itemId)->find();
    }
    
    //获取大于传入id的最近的一条数据
    public function getItemForGtId($id){
        return Db::table(TableUtils::getTableDetails('goods_list'))->where(
            TableUtils::getTableDetails('id','>', 'id'), $id)->limit(1)->order("id asc")->find();
    }
    
    public  function updateItem($id,$data){
        return Db::table(TableUtils::getTableDetails('goods_list'))->where(
            TableUtils::getTableDetails('goods_list', 'id'), $id)
            ->setField($data);
    }
    
    //更新商品页面关键词
    public function updateKeyword($id,$data){
        return Db::table(TableUtils::getTableDetails('goods_list'))->where(
            TableUtils::getTableDetails('goods_list', 'id'), $id)
            ->setField($data);
    }
    
    /**
     * 抛弃不用，性能不行
     * @param number $randCount
     * @return \think\Collection|\think\db\false|PDOStatement|string
     */
    
    /* public function getRandList($randCount=10){
        $table= Db::table(TableUtils::getTableDetails('goods_list'))
        ->alias('a')
        ->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId') 
        ->join('taobao_item_info w','a.itemId = w.itemId','LEFT');
        $data=$table->order('rand()')->limit($randCount)->select();
        //echo $table->getLastSql();
        return $data;
    } */
    
    public function getRandList($randCount=10){
        //$table= Db::query("SELECT * FROM `".TableUtils::getTableDetails('goods_list')."`  AS t1 JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) FROM `".TableUtils::getTableDetails('goods_list')."`)) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id ASC LIMIT ".$randCount);
            //echo $table->getLastSql();
         
        $tableCount= Db::table(TableUtils::getTableDetails('goods_list'));
        $count=$tableCount->count();
        $randId=rand(0,$count-$randCount);
        
        $table= Db::table(TableUtils::getTableDetails('goods_list'))
        ->alias('a')
        ->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId')
            ->join('taobao_item_info w','a.itemId = w.itemId','LEFT')
             ->where("a.id>=".$randId) ;
        $data=$table/* ->order('rand()') */->limit($randCount)->select();
        //echo $table->getLastSql();
        return $data;
    }
    
    
    public function getPrveList($id=10,$randCount=10){
        $table= Db::table(TableUtils::getTableDetails('goods_list'))
        ->alias('a')
        ->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId')
            ->join('taobao_item_info w','a.itemId = w.itemId','LEFT')
            ->where("id","<",$id);
            $data=$table->limit($randCount)->select();
            //echo $table->getLastSql();
            return $data;
    }
}

?>