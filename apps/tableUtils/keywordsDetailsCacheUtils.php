<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;


class keywordsDetailsCacheUtils{
    public static function addKeywordsDetailsCache($data){
        return Db::table(TableUtils::getTableDetails('keywords_details_cache'))->insert($data);
    }
    
    public static function updateKeywordsDetailsCache($data,$id){
        return Db::table(TableUtils::getTableDetails('keywords_details_cache'))->where(TableUtils::getTableDetails('keywords_details_cache', 'id'), $id)->update($data);
        
    }
}