<?php
return [
    // 关键词表
    
    'keywords' => [
        'table_name' => 'keywords',
        'table_field' => [
            'id' => 'id',
            'keyword' => 'keyword',
            'kw_md5'=>'kw_md5',
            'subKeyWords'=>'subKeyWords',
            'subKeyWordsCount'=>'subKeyWordsCount',
            'update_time' => 'update_time'
        ]
    ],
    
    
    // 关键词表临时缓存表
    'keywords_cache' => [
        'table_name' => 'keywords_cache',
        'table_field' => [
            'id' => 'id',
            'keyword' => 'keyword',
            'kw_md5'=>'kw_md5',
            'subKeyWords'=>'subKeyWords',
            'subKeyWordsCount'=>'subKeyWordsCount',
            'update_time' => 'update_time'
        ]
    ],
    
    // 关键词数据获取表
    'keywords_details' => [
        'table_name' => 'keywords_details',
        'table_field' => [
            'id' => 'id',
            'keyword_id' => 'keyword_id',
            'json' => 'json',
            'page' => 'page',
            'page_size' => 'page_size',
            'update_time' => 'update_time'
        ]
    ],
    
    // 关键词临时数据获取表
    'keywords_details_cache' => [
        'table_name' => 'keywords_details_cache',
        'table_field' => [
            'id' => 'id',
            'keyword_id' => 'keyword_id',
            'json' => 'json',
            'page' => 'page',
            'page_size' => 'page_size',
            'update_time' => 'update_time'
        ]
    ],
    
    //
    'index_cate'=>[
        'table_name'=>'index_cate',
        'table_field'=>[
            'id'=>'id',
            'cate_name'=>'cate_name',
            'url'=>'url',
            'status'=>'status',
            'type'=>'type',
        ]
    ],
    
    'goods_list' => [
        'table_name' => 'goods_list',
        'table_field' => [
            'id' => 'id',
            'keyword_id' => 'keyword_id',
            'title' => 'title',
            'keyWords'=>'keyWords',
            'itemId' => 'itemId',
            'zkFinalPriceWap' => 'zkFinalPriceWap',
            'biz30Day' => 'biz30Day',
            'couponStartFee' => 'couponStartFee',
            'clickUrl' => 'clickUrl',
            'shareUrl' => 'shareUrl',
            'pictUrl' => 'pictUrl',
            'couponKey' => 'couponKey',
            'couponAmount' => 'couponAmount',
            'couponSendCount' => 'couponSendCount',
            'couponTotalCount' => 'couponTotalCount',
            'couponEffectiveStartTime' => 'couponEffectiveStartTime',
            'couponEffectiveEndTime' => 'couponEffectiveEndTime',
            'provcity' => 'provcity',
            'nick' => 'nick',
            'userType' => 'userType',
            'reason' => 'reason',
            'commentList' => 'commentList',
            'askeverybodyList' => 'askeverybodyList',
            'update_time' => 'update_time'
        ]
    ],
    
    // 代理地址
    'proxy_ip' => [
        'table_name' => 'proxy_ip',
        'table_field' => [
            'id' => 'id',
            'ip' => 'ip',
            'port' => 'port',
            'http_type' => 'http_type',
            'status' => 'status',
            'log' => 'log',
            'update_time' => 'update_time'
        ]
    ],
    
    // 淘宝 tk
    'tbk_token' => [
        'table_name' => 'tbk_token',
        'table_field' => [
            'id' => 'id',
            'proxy_id' => 'proxy_id',
            'tk' => 'tk',
            'status' => 'status',
            'update_time' => 'update_time'
        ]
    ],
    
    
    // 淘宝 达人
    'daren' => [
        'table_name' => 'daren',
        'table_field' => [
            'id' => 'id',
            'data' => 'data',
        ]
    ],
    
    
    // 淘宝 试用
    'taobao_try_item' => [
        'table_name' => 'taobao_try_item',
        'table_field' => [
            'id' => 'id',
            'cate'=>'cate',
            'itemId'=>'itemId',
            'reportId'=>'reportId',
            'keywords'=>'keywords',
            'data' => 'data',
            'update_time'=>'update_time',
        ]
    ],
    
    
    // 淘宝 试用分类
    'taobao_try_cate' => [
        'table_name' => 'taobao_try_cate',
        'table_field' => [
            'id' => 'id',
            'cate_id'=>'cate_id',
            'cate_name'=>'cate_name',
           
        ]
    ],
    
    
    // 淘宝 信息表
    'taobao_item_info' => [
        'table_name' => 'taobao_item_info',
        'table_field' => [
            'id' => 'id',
            'itemId'=>'itemId',
            'keywords'=>'keywords',
            'title'=>'title',
            'reason'=>'reason',
            'commentList'=>'commentList',
            'askeverybodyList'=>'askeverybodyList',
            'collectCount'=>'collectCount',
            'update_time'=>'update_time',
        ]
    ],
    
    
    //必买清单分类
    'buyinventory_cate' => [
        'table_name' => 'buyinventory_cate',
        'table_field' => [
            'id' => 'id',
            'psId'=>'psId',
            'sceneId'=>'sceneId',
            'cate_name'=>'cate_name',
        ]
    ],
    
    //必买清单详情
    'buyinventory_item_info' => [
        'table_name' => 'buyinventory_item_info',
        'table_field' => [
            'id' => 'id',
            'cate_id'=>'cate_id',
            'contentId'=>'contentId',
            'keywords'=>'keywords',
            'data'=>'data',
            'update_time'=>'update_time',
        ]
    ],
    
    //资讯id 必买清单（
    'article_contentid' => [
        'table_name' => 'article_contentid',
        'table_field' => [
            'id' => 'id',
            'status'=>'status',
            'contentId'=>'contentId',
            'collectCount'=>'collectCount',
            'update_time'=>'update_time',
        ]
    ],
    
    
    //必买清单tags
    'buyinventory_tags' => [
        'table_name' => 'buyinventory_tags',
        'table_field' => [
            'id' => 'id',
            'tag_name'=>'tag_name',
            'md5'=>'md5',
            'update_time'=>'update_time',
        ]
    ],
] 
?>
    