<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;


class keywordsUtils{
    public static function getKeyword($keyword_id,$page=1){
        return $keywords_details = Db::table(TableUtils::getTableDetails('keywords_details'))->where(TableUtils::getTableDetails('keywords_details', 'keyword_id'), $keyword_id)
        ->where(TableUtils::getTableDetails('keywords_details', 'page'), $page)
        ->find();
    }
    
    public static function updateKeyword($data,$id){
         return Db::table(TableUtils::getTableDetails('keywords'))->where(
            TableUtils::getTableDetails('keywords', 'id'), $id)
            ->setField($data);
    }
    
    public static function getidForKeyword($id){
        return Db::table(TableUtils::getTableDetails('keywords'))->where(
            TableUtils::getTableDetails('keywords', 'id'), $id)
            ->find();
    }
    
    public static function getRandHotSearchWord(){
        return Db::table(TableUtils::getTableDetails('keywords'))->order('rand()')
        ->limit(5)->select();
    }
    
    
    public static function addHotKeyWords($data){
        return $keywords_details = Db::table(TableUtils::getTableDetails('keywords'))
        ->insert($data);
    }
    
    public static function findHotKeyWordsMd5($keyWordMd5){
        return Db::table(TableUtils::getTableDetails('keywords'))->where(
            TableUtils::getTableDetails('keywords', 'kw_md5'), $keyWordMd5)
            ->find();
    }
    
    public static function getKeyWordsList($page=1,$pageSize=20){
        return Db::table(TableUtils::getTableDetails('keywords'))
        ->limit($pageSize*($page-1),$pageSize)
        ->order("collectCount asc,update_time asc,id asc")->select();
    }
    
    public static function getKeyWordsForSubKeyWordsNullList($page=1,$pageSize=20){
        return Db::table(TableUtils::getTableDetails('keywords'))
        ->where(TableUtils::getTableDetails('keywords', 'subKeyWords'), null)
        ->limit($pageSize*($page-1),$pageSize)->order("subKeyWordsCount asc")->select();
    }
    
    public  function updateSubKeyWords($id,$data){
        return Db::table(TableUtils::getTableDetails('keywords'))->where(
            TableUtils::getTableDetails('keywords', 'id'), $id)
            ->setField($data);
    }
}
?>