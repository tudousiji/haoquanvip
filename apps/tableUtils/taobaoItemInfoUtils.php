<?php
namespace app\tableUtils;

use think\Db;
use app\utils\TableUtils;

class taobaoItemInfoUtils
{
    public  function updateAskeverybodyList($data,$itemId){
        return Db::table(TableUtils::getTableDetails('taobao_item_info'))->where(
            TableUtils::getTableDetails('taobao_item_info', 'itemId'), $itemId)
            ->setField($data);
    }
    
    public  function updateReasonList($data,$itemId){
        return Db::table(TableUtils::getTableDetails('taobao_item_info'))->where(
            TableUtils::getTableDetails('taobao_item_info', 'itemId'), $itemId)
            ->setField($data);
    }
    
    public  function updateCommentList($data,$itemId){
        return Db::table(TableUtils::getTableDetails('taobao_item_info'))->where(
            TableUtils::getTableDetails('taobao_item_info', 'itemId'), $itemId)
            ->setField($data);
    }

    public function autoItemId($itemId,$keywords_title, $isCheckExitItemId = true,$keywords=null)
    {
        if (empty($itemId) || ! is_numeric($itemId)) {
            return;
        }
        if ($isCheckExitItemId) {
            $status = Db::table(TableUtils::getTableDetails('taobao_item_info'))->where(TableUtils::getTableDetails('taobao_item_info', 'itemId'), $itemId)->find();
        }
        if ($status == null || ! $isCheckExitItemId) {
            $title=null;
            if(empty($keywords) ||  $keywords==null){
                $title=strip_tags($keywords_title);
            }
            $array = [
                'itemId' => $itemId,
                'update_time'=>0,
                'title'=>$title,
                'keywords'=>$keywords,
            ];
            Db::table(TableUtils::getTableDetails('taobao_item_info'))->insert($array);
        }
    }

    public function getTaobaoInfoList($page = 1, $pageSize = 20, $isOr = true)
    {
        $table = Db::table(TableUtils::getTableDetails('taobao_item_info'));
        if ($isOr) {
            /* $condition="\"".TableUtils::getTableDetails('taobao_item_info', 'reason') ."|".
            TableUtils::getTableDetails('taobao_item_info', 'commentList') ."|".
            TableUtils::getTableDetails('taobao_item_info', 'askeverybodyList')."\"";
            */
            $table->where('keywords|reason|commentList|askeverybodyList', null);
        } else {
            $table->where(TableUtils::getTableDetails('taobao_item_info', 'reason'), null)->$table->where(TableUtils::getTableDetails('taobao_item_info', 'commentList'), null)->$table->where(TableUtils::getTableDetails('taobao_item_info', 'askeverybodyList'), null);
        }
        $data=$table->limit(($page - 1) * $pageSize, $pageSize)->select();
        return $data;
    }
    
    
    public function getTaobaoInfoListForTime( $isOr = true,$count=2,$time=24*60*60)
    {
        $table = Db::table(TableUtils::getTableDetails('taobao_item_info'))->alias('a');
        if ($isOr) {
            $table->where('keywords|reason|commentList|askeverybodyList', null);
        } else {
            $table->where(TableUtils::getTableDetails('taobao_item_info', 'reason'), null)->$table->where(TableUtils::getTableDetails('taobao_item_info', 'commentList'), null)->$table->where(TableUtils::getTableDetails('taobao_item_info', 'askeverybodyList'), null);
        }
        $table->where(TableUtils::getTableDetails('taobao_item_info', 'update_time'),"<=",time()-$time);
        $data=$table->limit($count)->order(TableUtils::getTableDetails('taobao_item_info', 'collectCount')." asc,update_time asc,id asc")->select();
        return $data;
    }
    
    
    public  function updateTaobaoItemInfo($data,$itemId){
        $table= Db::table(TableUtils::getTableDetails('taobao_item_info'));
        $data=$table->where(
            TableUtils::getTableDetails('taobao_item_info', 'itemId'), $itemId)
            ->setField($data);
        //echo $table->getLastSql();
        return $data;
    }
    
}