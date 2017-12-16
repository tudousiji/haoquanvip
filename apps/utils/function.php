<?php


// 关键词查询优惠券
function getKeyWord($keyWord, $page = 1, $pageSize = 100)
{
    // $url = "http://uland.taobao.com/cp/pc_coupon_list?pid=" . $GLOBALS['pid'] . "&queryCount=" . $pageSize . "&page=" . $page . "&pageSize=" . $pageSize . "&channel=channel=couponlist_" . $keyWord;
    $url = "http://1212.ip138.com/ic.asp";
    // var_dump(randIP());
    return app\utils\NetUtils::curlData("GET", $url, null, false);
}

function getMillisecond()
{
    list ($t1, $t2) = explode(' ', microtime());
    return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

// 此函数提供了国内的IP地址
function randIP()
{
    $ip_long = array(
        array(
            '607649792',
            '608174079'
        ), // 36.56.0.0-36.63.255.255
        array(
            '1038614528',
            '1039007743'
        ), // 61.232.0.0-61.237.255.255
        array(
            '1783627776',
            '1784676351'
        ), // 106.80.0.0-106.95.255.255
        array(
            '2035023872',
            '2035154943'
        ), // 121.76.0.0-121.77.255.255
        array(
            '2078801920',
            '2079064063'
        ), // 123.232.0.0-123.235.255.255
        array(
            '-1950089216',
            '-1948778497'
        ), // 139.196.0.0-139.215.255.255
        array(
            '-1425539072',
            '-1425014785'
        ), // 171.8.0.0-171.15.255.255
        array(
            '-1236271104',
            '-1235419137'
        ), // 182.80.0.0-182.92.255.255
        array(
            '-770113536',
            '-768606209'
        ), // 210.25.0.0-210.47.255.255
        array(
            '-569376768',
            '-564133889'
        ) // 222.16.0.0-222.95.255.255
    );
    $rand_key = mt_rand(0, 9);
    $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
    $headers['CLIENT-IP'] = $ip;
    $headers['X-FORWARDED-FOR'] = $ip;
    
    $headerArr = array();
    foreach ($headers as $n => $v) {
        $headerArr[] = $n . ':' . $v;
    }
    return $headerArr;
}

function qPage($nowPage=1,$isNextpage=true){
    $array=[
        'isPrevPage'=>array("status"=>$nowPage==1?false:true,"page"=>$nowPage==1?$nowPage:$nowPage-1),
        'isNextPage'=>array("status"=>$isNextpage,"page"=>$isNextpage?$nowPage+1:$nowPage),
    ];
    return $array;
}

function page($nowPage=1,$count=20,$pageSize=20){
    $startPage=0;
    if($nowPage>5){
        $startPage=$nowPage-5;
    }else{
        $startPage=1;
    }
    
    
    $pageCount=$count%$pageSize==0?(int)$count/$pageSize:((int)($count/$pageSize)+1);
    
    $endPage=$pageCount;
    if($nowPage<=$pageCount-5){
        $endPage=$nowPage+5;
    }
   
    $arr=[];
    $index=0;
    for($i=$startPage;$i<=$endPage;$i++){
        $arr[]=$startPage+$index;
        $index++;
    }
    
    $page=[
        'page'=>$arr,
        'pageCount'=>$pageCount,
        'nowPage'=>$nowPage,
        'startPage'=>$startPage,
        'endPage'=>$endPage,
    ];
    
    return $page;
}


function urlIdcode($id,$isEncode=true){
    $n = "$id";
    $keyConfig=require 'apps/config/keyConfig.php';
    $urlEncodeKey= $keyConfig['urlEncodeKey'];
    $key = "$urlEncodeKey";
    $r = '';
    if($isEncode){//加密
        for($i=0; $i<strlen($n); $i++) {
            $k = $key{$i%strlen($key)};
            $r .= ($n{$i} + $k) % 10;
        }
    }else{
        for($i=0; $i<strlen($n); $i++) {
            $k = $key{$i%strlen($key)};
            $r .= ($n{$i} < $k ? $n{$i} + 10: $n{$i}) - $k;
        }
    }
    return $r;
}

//中文截取
function chinesesubstr($str,$start,$len){
    $strlen = $len - $start;    //定义需要截取字符的长度
    $tmpstr="";
    for($i=0;$i<$strlen;$i++){                   //使用循环语句，单字截取，并用$tmpstr.=$substr(？，？，？)加起来
        if(ord(substr($str,$i,1))>0xa0){     //ord()函数取得substr()的第一个字符的ASCII码，如果大于0xa0的话则是中文字符
            $tmpstr.=substr($str,$i,3);        //设置tmpstr递加，substr($str,$i,3)的3是指三个字符当一个字符截取(因为utf8编码的三个字符算一个汉字)
            $i+=2;
        }else{                                             //其他情况（英文）按单字符截取
            $tmpstr.=substr($str,$i,1);
        }
        
    }
    
    return $tmpstr;
}

?>