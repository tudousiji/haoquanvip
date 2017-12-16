<?php
return [
    'host'=>'http://www.haoquanvip.com/',
    'urlEncodeKey'=>'1990',//纯数字，不能修改，否则整个网站将无法访问
    'img_size'=>[
        'small'=> '_200x200.jpg'
    ],
    /* 'keywords_from_table'=>[
        'goods_list'=>1,
        'taobao_try_item'=>2,
    ], */
    'is_web_collector'=>true,//是否网页采集淘宝信息,true是，python爬虫一样可以采集，开启后网速变慢
    'title'=>"淘宝优惠券,天猫优惠券,淘宝内部优惠券,天猫内部优惠券,京东优惠券,好券vip",
    'subtitle'=>'淘宝优惠券,天猫优惠券,淘宝内部优惠券,天猫内部优惠券,京东优惠券',
    'description'=>"好券vip是淘宝(天猫)内部优惠券领取网站,独家优惠券直接领取,领取后可直接下单抵扣,价格超实惠。千万淘宝优惠券每天更新,上淘宝(天猫)购物先上好券vip,比双11更低!好券vip,更懂你的实时优惠播报站-让优惠触手可及",
    'keyWords'=>"淘宝优惠券,天猫优惠券,淘宝内部优惠券,天猫内部优惠券,京东优惠券,好券vip",
    'pid' => 'mm_29947721_14832832_57874820',
    'cache_time' => '5', // 秒
    'keyWordPageSize'=>20,//默认
    'keyWordCollectionPageSize'=>500,//默认
    'taobaoke_keyword' => 'http://api.m.taobao.com/h5/mtop.alimama.ertao.graphql.query/1.0/?appKey=12574478&t=%s&sign=%s&api=mtop.alimama.ertao.graphql.query&v=1.0&type=jsonp&dataType=jsonp&callback=mtopjsonp1&data=',
    'taobaoke_keyword_data' => '{"query":"query auctionQuery($condition: LunaCondition) {auctionList(condition: $condition) {pageInfo {totalCount}auctions {nid title zkFinalPriceWap biz30Day couponEffectiveStartTime provcity nick couponEffectiveEndTime couponStartFee clickUrl shareUrl pictUrl couponKey couponAmount couponSendCount couponTotalCount userType}}}","variables":"{\"condition\":{\"q\":\"%s\",\"offset\":%s,\"count\":%s,\"complement\":false,\"pid\":\"%s\",\"searchMap\":{\"price\":\"0~\",\"summaryfields\":\"npx_score,coupon,tk_mkt_activity_id,tk_mkt_rates,MAX_tk_event_eids,MAX_tk_event_creator_ids\",\"src_scene\":\"\",\"querytype\":\"couponlist\",\"distfield\":\"\"},\"serviceList\":[\"dpyhq\"]},\"bizEnvVars\":{\"pid\":\"%s\",\"st\":\"\"}}"}',
    'taobao_img_url'=>'https://img.alicdn.com/',
    // 'is_open_page'=>false,
    //  新加字段 couponEffectiveStartTime provcity nick couponEffectiveEndTime 
    'baiDuWordPos'=>"http://zhannei.baidu.com/api/customsearch/keywords?title=%s",//百度分词获取地址
    'taoBaoKeyWords'=>"https://suggest.taobao.com/sug?code=utf-8&q=%s",//淘宝关键词生成
    //'comment_list' =>'https://rate.taobao.com/feedRateList.htm?auctionNumId=%s&userNumId=3089150000&currentPageNum=%s&pageSize=%s&rateType=&orderType=sort_weight&attribute=&sku=&hasSku=true&folded=0&callback=jsonp_tbcrate_reviews_list',//评论
   // 'comment_list'=>'https://rate.tmall.com/list_detail_rate.htm?itemId=%s&sellerId=123&Page=%s',
    'comment_list'=>'https://rate.tmall.com/list_detail_rate.htm?itemId=%s&sellerId=123&Page=%s&callback=jsonp_tbcrate_reviews_list',
    'comment_list_cache_time'=>-1,//-1是永久不更新
    'askEverybody_list' =>''  ,//问大家
    'reason_list'=>'https://rate.taobao.com/detailCommon.htm?auctionNumId=%s&userNumId=123&callback=json_tbc_rate_summary',
    'reason_list_cache_time'=>-1,//-1是永久不更新
    //https://rate.taobao.com/detailCommon.htm?auctionNumId=13654813327&userNumId=721822968&ua=090%23qCQXoXXqXqwX2Ti0XXXXXQkOIHplk0GhflnoIeGXAGBpfHQbcYRtGw13OHRYHaLiXXB%2B0ydC24QX%2FXXxhejwBHdvXOjvwSB9I1VX43oJ3vQXiPR22a4tXvXQ0ZsNLKQiXi8mLdxXNb2FZeUd2%2FlYOIlrZ1RLytEh9CUxH4QXa%2FY9%2BWO3id1UPvQXiJ%2BvQBiCxkLiXaHPsiLNwqi5vLjlQSuvwud6m6vBDKavKLNPsi%2FBwqi82LjlQDuvwuDskvQXisty2Jq95T%3D%3D&callback=json_tbc_rate_summary 好评中评差评的个数等
    //https://api.m.taobao.com/h5/mtop.taobao.ocean.quest.detail.pc/1.0/?appKey=12574478&t=1505815380288&sign=3ec6baef3c8889c74380d3422fdeb657&api=mtop.taobao.ocean.quest.detail.pc&v=1.0&type=jsonp&dataType=jsonp&callback=mtopjsonp3&data=%7B%22topicId%22%3A%2290207620086%22%7D 问大家
];

?>