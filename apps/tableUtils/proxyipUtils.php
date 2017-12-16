<?php
namespace app\tableUtils;
use think\Db;
use app\utils\TableUtils;
class proxyipUtils{
    public static function addProxtIp($data){
        return $keywords_details = Db::table(TableUtils::getTableDetails('proxy_ip'))
        ->insert($data);
    }
    
    public static function updateFailProxtIp($data,$id){
        return $keywords_details = Db::table(TableUtils::getTableDetails('proxy_ip'))
        ->where(TableUtils::getTableDetails('proxy_ip', 'id'), $id)
        ->setField($data);
    }
}
?>