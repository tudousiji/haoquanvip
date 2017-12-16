<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;

class tryoutUtils{
    public static function addTryout($data){
        return $keywords_details = Db::table(TableUtils::getTableDetails('taobao_try_item'))
        ->insert($data);
    }
    
    public function getTryout($itemId=0,$reportId=0){
        return Db::table(TableUtils::getTableDetails('taobao_try_item'))->
        where(TableUtils::getTableDetails('taobao_try_item', 'itemId'), $itemId)->
        where(TableUtils::getTableDetails('taobao_try_item', 'reportId'), $reportId)
        ->find();
    }
    
    public function getCate(){
        $table= Db::table(TableUtils::getTableDetails('taobao_try_cate'));
        $data = $table->select();
        //echo $table->getLastSql();
        return $data;
    }
    
    public function getTryOutCate($id){
        return Db::table(TableUtils::getTableDetails('taobao_try_cate'))->
        where(TableUtils::getTableDetails('taobao_try_cate', 'id'), $id)
        ->find();
    }
    
    public function getTryOutCateId($cateId){
        return Db::table(TableUtils::getTableDetails('taobao_try_cate'))->
        where(TableUtils::getTableDetails('taobao_try_cate', 'cate_id'), $cateId)
        ->find();
    }
    
    public function getTryOutData($id){
        $table= Db::table(TableUtils::getTableDetails('taobao_try_item'))
        ->alias('a')->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId') ->
        where("taobao_try_item.".TableUtils::getTableDetails('taobao_try_item', 'id'), $id)
        ->join('taobao_item_info w','a.itemId = w.itemId','LEFT');
        $data=$table->find();
        //echo $table->getLastSql();
        return $data;
    }
    
    public function getList($cateid, $page = 1,$pageSize=20)
    {
        $table = Db::table(TableUtils::getTableDetails('taobao_try_item'))
        ->alias('a')->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId') 
        ->where("taobao_try_item.".TableUtils::getTableDetails('taobao_try_item', 'cate'), $cateid)
        ->join('taobao_item_info w','a.itemId = w.itemId','LEFT')
        ->limit(($page-1)*$pageSize,$pageSize);
        $list=$table->select();
        //echo $table->getLastSql();
        /***
         * SELECT `a`.*,`w`.`keywords`,`w`.`reason`,`w`.`commentList`,`w`.`askeverybodyList`,w.itemId as taobao_item_info_itemId FROM `taobao_try_item` `a` LEFT JOIN `taobao_item_info` `w` ON `a`.`itemId`=`w`.`itemId` WHERE `a`.`cate` = 0 AND `a`.`id`>=(SELECT `id` FROM `taobao_try_item` LIMIT 0,1 ) LIMIT 20
         */
        return $list;
    }
    
    public function getCount($cateId="")
    {
        $tableObg = Db::table(TableUtils::getTableDetails('taobao_try_item'));
        
        if(is_numeric($cateId)){
            $tableObg->where(TableUtils::getTableDetails('taobao_try_item', 'cate'), $cateId);
        }
        $count=$tableObg->count();
        return $count;
    }
    
    /**
     * 抛弃不用，性能不行
     * @param number $randCount
     * @return \think\Collection|\think\db\false|PDOStatement|string
     */
    /* public function getRandList($randCount=10){
        $table = Db::table(TableUtils::getTableDetails('taobao_try_item'))
        ->alias('a')->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId') 
        ->join('taobao_item_info w','a.itemId = w.itemId','LEFT');
        $data = $table->order('rand()')
        ->limit($randCount)->select();
        
        return $data;
    } */
    public function getRandList($randCount=10){
        //$table= Db::query("SELECT * FROM `".TableUtils::getTableDetails('taobao_try_item')."`  AS t1 JOIN (SELECT ROUND(RAND() * (SELECT MAX(id) FROM `".TableUtils::getTableDetails('taobao_try_item')."`)) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id ASC LIMIT ".$randCount);
        //echo $table->getLastSql();
        
        $tableCount = Db::table(TableUtils::getTableDetails('taobao_try_item'));
        $count=$tableCount->count();
        $randId=rand(0,$count-$randCount);
        
        $table = Db::table(TableUtils::getTableDetails('taobao_try_item'));
        $table->alias('a')->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId')
            ->join('taobao_item_info w','a.itemId = w.itemId','LEFT')
             ->where("a.id>=".$randId) ;
        $data = $table/* ->order('rand()') */
            ->limit($randCount)->select();
        //echo $table->getLastSql();
        return $data;
    }
    
    public function getPrveRandList($id,$randCount=10){
        $table = Db::table(TableUtils::getTableDetails('taobao_try_item'))
        ->alias('a')->field('a.*,w.keywords
            ,w.reason,w.commentList,
            w.askeverybodyList,w.itemId as taobao_item_info_itemId')
            ->join('taobao_item_info w','a.itemId = w.itemId','LEFT')
            ->where("id","<",$id);;
            $data = $table
            ->limit($randCount)->select();
            
            return $data;
    }
}
    