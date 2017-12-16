<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;

class articleContentidUtils{
    /**
     * 检测重复ContentId
     */
    public function checkRepeatContentId($ids){
        $table = Db::field(TableUtils::getTableDetails('article_contentid', 'contentId'))
        ->table('article_contentid')
        ->where("contentId","in",$ids)
        //->union('SELECT '.TableUtils::getTableDetails('article_contentid', 'contentId').' FROM '.TableUtils::getTableDetails('article_contentid'))
        ->union('SELECT '.TableUtils::getTableDetails('article_contentid', 'contentId').' FROM '.TableUtils::getTableDetails('buyinventory_item_info') ." where contentId in (".$ids.")");
        
        $data=$table->select();
        //echo $table->getLastSql();
        
        return $data;
    }
    
    public function addContentId($data){
        return $contentId = Db::table(TableUtils::getTableDetails('article_contentid'))
        ->insert($data);
    }
    
}