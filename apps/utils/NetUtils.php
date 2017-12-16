<?php
namespace app\utils;

use think\Db;
require_once 'apps/utils/function.php';


class NetUtils
{

    public static function curlDataTest($url){
        $ch = curl_init();
        $headers = array();
        $headers[] = 'Host:' . parse_url($url)['host'];
        $headers[] = 'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0';
        $headers[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3';
        $headers[] = 'Connection:keep-alive';
        $headers[] = 'Upgrade-Insecure-Requests:1';
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $headers);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        //打印获得的数据
        //var_dump(curl_error($ch));
        //var_dump($output);
        curl_close($ch);
    } 
    
    public static function getData($url){
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
        return file_get_contents($url);
    }

    // 网络请求
    public static function curlData($RequestType = 'GET', $url, $parameter/* ,$post_data =array(),$is_proxy,$header="0",$cookie="",$isHttps=false */)
    {
        if ((! isset($url) && ! (isset($parameter['isTbk']) && ! empty($parameter['isTbk']) && $parameter['isTbk'])) || ! isset($RequestType) || (isset($url) && empty($url) && ! (isset($parameter['isTbk']) && ! empty($parameter['isTbk']) && $parameter['isTbk'])) || (isset($RequestType) && empty($RequestType))) {
            echo "url empty or RequestType empty";
            return;
        }
        $post_data = isset($parameter['post_data']) && is_array($parameter['post_data']) && count($parameter['post_data']) > 0 ? $parameter['post_data'] : array();
        $is_proxy = isset($parameter['is_proxy']) ? $parameter['is_proxy'] : false;
        $header_type = isset($parameter['header_type']) ? $parameter['header_type'] : 0;
        $cookie = isset($parameter['cookie']) ? $parameter['cookie'] : "";
        $isHttps = isset($parameter['isHttps']) ? $parameter['isHttps'] : false;
        
        $tk = null;
       
        if (isset($parameter['isTbk']) && $parameter['isTbk']) {
            $url = trim($parameter['taobaoke_keyword'] . urlencode($parameter['taobaoke_keyword_data']));
            $tk = Db::table(TableUtils::getTableDetails('tbk_token'))->where(TableUtils::getTableDetails('tbk_token', 'status'), 0)
                ->order('rand()')
                ->limit(1)
                ->find();
              
            if (isset($tk)) {
                
                $tk_preix = null;
                if (isset($tk) && isset($tk[TableUtils::getTableDetails('tbk_token', 'tk')]) && ! empty($tk[TableUtils::getTableDetails('tbk_token', 'tk')])) {
                    $cookie = $tk[TableUtils::getTableDetails('tbk_token', 'tk')];
                    $tk_preix = explode("_", explode("=", explode(";", $cookie)[0])[1])[0];
                }
                $time = getMillisecond();
                $md5s = $tk_preix . "&" . $time . "&12574478&" . $parameter['taobaoke_keyword_data'];
                $url = trim(sprintf($parameter['taobaoke_keyword'], $time, md5($md5s)) . urlencode($parameter['taobaoke_keyword_data']));
                //echo urldecode($url) ;
            }
        }
        
        $ch = curl_init();
        
        $headers = array();
        $headers[] = 'Host:' . parse_url($url)['host'];
        $headers[] = 'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0';
        $headers[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3';
        //$headers[] = 'Accept-Encoding:gzip,deflate';
        $headers[] = 'Connection:keep-alive';
        $headers[] = 'Upgrade-Insecure-Requests:1';
        //$headers[] = 'Cache-Control:max-age=0';
        //$headers[] = 'HTTP/1.1';
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $headers); 
        if (isset($cookie) && ! empty($cookie)) {
            
            curl_setopt($ch, CURLOPT_COOKIE, $cookie); // 使用上面获取的cookies
        }
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.baidu.com)'); 
        // $headers= array_merge($headers,randIP());
        curl_setopt($ch, CURLOPT_HEADER, $header_type);
        if (strtoupper($RequestType) != 'GET') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        } else {
            if (isset($post_data) && is_array($post_data) && count($post_data) > 0) {
                $parmant = http_build_query($post_data);
                if (substr($url, strlen($url) - 1, strlen($url)) == "?" || substr($url, strlen($url) - 1, strlen($url)) == "&") {
                    $url = $url . $parmant;
                } else if (strpos($url, "?") !== false) {
                    $url = $url . "&" . http_build_query($post_data);
                } else {
                    $url = $url . "?" . http_build_query($post_data);
                }
            }
        }
        
        $proxy_ip = null;
        if ($is_proxy) {
            $proxy_ip = Db::table(TableUtils::getTableDetails('proxy_ip'))->where(TableUtils::getTableDetails('proxy_ip', 'status'), 0)
                ->order('rand()')
                ->limit(1)
                ->find();
            // var_dump($proxy_ip);
            if (! empty($proxy_ip)) {
                
                curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); // 代理认证模式
                curl_setopt($ch, CURLOPT_PROXY, $proxy_ip[TableUtils::getTableDetails('proxy_ip', 'ip')]); // 代理服务器地址
                curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_ip[TableUtils::getTableDetails('proxy_ip', 'port')]); // 代理服务器端口
                                                                                                                // curl_setopt($ch, CURLOPT_PROXYUSERPWD, ":"); //http代理认证帐号，username:password的格式
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); // 使用http代理模式
            }
        }
        
        if ($isHttps || (isset($proxy_ip)) && is_null($proxy_ip) && ! empty($proxy_ip) && isset($proxy_ip[TableUtils::getTableDetails('proxy_ip', 'http_type')]) && $proxy_ip[TableUtils::getTableDetails('proxy_ip', 'http_type')] == 1) {
            // https开启下面这个
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); //存储cookies
        //echo $url;
        $output = curl_exec($ch);
       
        //var_dump(curl_error($ch));
        $body = "";
        $header = "";
        $jsonKeyValConfig=require 'apps/config/jsonKeyValConfig.php';
       // var_dump(curl_error($ch));
       // var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        //print_r($output);return ;
        //var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200' && $header_type == "1");
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200' && $header_type == "1") {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $response_header = substr($output, 0, $headerSize);
            $body = substr($output, $headerSize);
            //print_r($body);//return ;
            //var_dump($body);
            $content = [
                "response_header" => $response_header,
                'post_data' => $post_data,
                'is_proxy' => $is_proxy,
                'proxy_ip' => $proxy_ip,
                'request_header_type' => $header_type,
                'cookie' => $cookie,
                'isHttps' => $isHttps,
                'body' => self::handleBody(trim($body)),
                'requestType' => $RequestType,
                'url' => $url,
                'tokenObj' => isset($tk) && ! is_null($tk) && ! empty($tk) ? $tk : ""
            ];
            
            $content=array_merge($parameter,$content);//$content 必须在后面以便覆盖前面同名key
            
            if (! empty(curl_error($ch))) {
                
                $ref = [
                    'msg' => curl_error($ch),
                    'status' => $jsonKeyValConfig['Fail'],
                ];
                $content['ref'] = $ref;
            } else {
                $ref = [
                    'msg' => '',
                    'status' => $jsonKeyValConfig['Success'],
                ];
                $content['ref'] = $ref;
            }
            curl_close($ch);
            
            return $content;
        }
        $content =[];
        if($header_type == "1"){
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $response_header = substr($output, 0, $headerSize);
            $body = substr($output, $headerSize);
            
            $content = [
                "response_header" => $response_header,
                'post_data' => $post_data,
                'is_proxy' => $is_proxy,
                'proxy_ip' => $proxy_ip,
                'request_header_type' => $header_type,
                'cookie' => $cookie,
                'isHttps' => $isHttps,
                'body' => self::handleBody(trim($body)),
                'requestType' => $RequestType,
                'url' => $url,
                'tokenObj' => isset($tk) && ! is_null($tk) && ! empty($tk) ? $tk : ""
            ];
            
        }else{
            $content = [
                'post_data' => $post_data,
                'is_proxy' => $is_proxy,
                'proxy_ip' => $proxy_ip,
                'request_header_type' => $header_type,
                'cookie' => $cookie,
                'isHttps' => $isHttps,
                'body' => self::handleBody(trim($output)),
                'requestType' => $RequestType,
                'url' => $url,
                'tokenObj' => isset($tk) && ! is_null($tk) && ! empty($tk) ? $tk : ""
            ];
        }
        
        
        
        $content=array_merge( $parameter,$content);
        if (! empty(curl_error($ch))) {
            
            $ref = [
                'msg' => curl_error($ch),
                'status' => $jsonKeyValConfig['Fail'],
            ];
            
            $content['ref'] = $ref;
        } else {
            $ref = [
                'msg' => '',
                'status' => $jsonKeyValConfig['Success'],
            ];
            $content['ref'] = $ref;
        }
        
        //var_dump(curl_error($ch));
        if ( strpos(curl_error($ch), 'Could not resolve proxy:') != - 1 && isset($parameter['proxy_ip']['id']) && ! empty($parameter['proxy_ip']['id'])) {
            $dataUpdate = [
                TableUtils::getTableDetails('proxy_ip', 'status') => 2,
                TableUtils::getTableDetails('proxy_ip', 'update_time') => time(),
                TableUtils::getTableDetails('proxy_ip', 'log') => trim($parameter['ref']['msg'])
            ];
            
            Db::table(TableUtils::getTableDetails('proxy_ip'))->where(TableUtils::getTableDetails('proxy_ip', 'id'), $parameter['proxy_ip'][TableUtils::getTableDetails('proxy_ip', 'id')])->update($dataUpdate); // 更新失效的tk
        }
        
        curl_close($ch);
        return $content;
    }

    public static function parseTaobaokeKeyWords($parameter)
    {
        $jsonKeyValConfig=require 'apps/config/jsonKeyValConfig.php';
        $bodyStr = $parameter['body'];
        //print_r($bodyStr);
        if (isset($bodyStr) && ! empty($bodyStr) && $parameter['ref']['status'] == $jsonKeyValConfig['Success']) {
            $bodyObj = json_decode($bodyStr, true);
          
            if (isset($bodyObj) && is_array($bodyObj) && count($bodyObj) > 0 && isset($bodyObj['ret']) && is_array($bodyObj['ret']) && count($bodyObj['ret']) > 0 && ! empty($bodyObj['ret'][0]) && strtolower(substr($bodyObj['ret'][0], 0, 7)) != strtolower($jsonKeyValConfig['Success'])) {
                preg_match_all("/set\-cookie:([^\r\n]*)/i", $parameter['response_header'], $matches);
                if (isset($matches) && is_array($matches) && count($matches) > 1) {
                    preg_match("/_m_h5_tk=([a-zA-Z0-9_]{0,});/i", $matches[1][0], $_m_h5_tk);
                    preg_match("/_m_h5_tk_enc=([a-zA-Z0-9_]{0,})/i", $matches[1][1], $_m_h5_tk_enc);
                    if(is_array($_m_h5_tk) && count($_m_h5_tk)>0 &&  is_array($_m_h5_tk_enc) && count($_m_h5_tk_enc)>0){
                        $parameter['cookie'] = $_m_h5_tk[0] . $_m_h5_tk_enc[0];
                        $data = [
                            TableUtils::getTableDetails('tbk_token', 'tk') => $parameter['cookie'],
                            TableUtils::getTableDetails('tbk_token', 'status') => 0,
                            TableUtils::getTableDetails('tbk_token', 'update_time') => time()
                        ];
                        if (isset($bodyObj['proxy_ip']) && is_null($bodyObj['proxy_ip']) && is_array($bodyObj['proxy_ip']) && count($bodyObj['proxy_ip']) > 0) {
                            $data['proxy_id'] = $bodyObj['proxy_ip'][TableUtils::getTableDetails('proxy_ip', 'id')];
                        }
                        Db::table(TableUtils::getTableDetails('tbk_token'))->insert($data);
                    }
                   
                    
                    if (isset($parameter['tokenObj']) && ! is_null($parameter['tokenObj']) && ! empty($parameter['tokenObj'])) {
                        $dataUpdate = [
                            TableUtils::getTableDetails('tbk_token', 'status') => 1,
                            TableUtils::getTableDetails('tbk_token', 'update_time') => time()
                        ];
                        // var_dump($parameter['tokenObj']) ;
                        Db::table(TableUtils::getTableDetails('tbk_token'))->where(TableUtils::getTableDetails('tbk_token', 'id'), $parameter['tokenObj'][TableUtils::getTableDetails('tbk_token', 'id')])->update($dataUpdate); // 更新失效的tk
                    }
                }
                //var_dump("再次请求");
                
                $twoGetData = self::curlData($parameter['requestType'], $parameter['url'], $parameter);
                if($parameter['ref']['status'] == $jsonKeyValConfig['Success']){
                    return $twoGetData;
                }else{
                    $parameter['is_proxy']=false;
                    return self::curlData($parameter['requestType'], $parameter['url'], $parameter);
                }
            }
        } else if (isset($parameter['ref']) && isset($parameter['ref']['status']) && $parameter['ref']['status'] == $jsonKeyValConfig['Fail']) {
            
            if (isset($parameter['ref']['msg']) && strpos(trim($parameter['ref']['msg']), 'Could not resolve proxy:') != - 1 && isset($parameter['proxy_ip']['id']) && ! empty($parameter['proxy_ip']['id'])) {
                $dataUpdate = [
                    TableUtils::getTableDetails('proxy_ip', 'status') => 2,
                    TableUtils::getTableDetails('proxy_ip', 'update_time') => time(),
                    TableUtils::getTableDetails('proxy_ip', 'log') => trim($parameter['ref']['msg'])
                ];
                
                Db::table(TableUtils::getTableDetails('proxy_ip'))->where(TableUtils::getTableDetails('proxy_ip', 'id'), $parameter['proxy_ip'][TableUtils::getTableDetails('proxy_ip', 'id')])->update($dataUpdate); // 更新失效的tk
            }
        }
        return $parameter;
    }

    public static function handleBody($body)
    {
        $str = 'mtopjsonp1(';
   
        $body=trim($body);
        if (stripos($body, $str) === 0) {
            $body = substr($body, strlen($str), strripos($body,")")-strlen($str));
        }
        return $body;
    }
    
    
    //获取百度关键词
    public static function BaiDuKeyWords($keyWords){
        if(empty($keyWords) || strlen($keyWords)<=0){
            echo "关键词不能为空";
            return ;
        }
        $keyConfig=require ('apps/config/keyConfig.php');
        $url=sprintf($keyConfig['baiDuWordPos'],$keyWords);
        $parameter = [
            'is_proxy' => true,
        ];
        $keyArrayJsonObj = curlData('GET',$url,$parameter);
        $keyArrayJson=$keyArrayJsonObj['body'];
        if(!empty($keyArrayJson)){
            $keyArray=json_decode($keyArrayJson);
            if(is_array($keyArray) && isset($keyArray['result']) && isset($keyArray['result']['_ret'])==0){
                return $keyArray['result']['res']['keyword_list'];
            }else{
                return array();
            }
        }else{
            return array();
        }
    }
    
    
    
    
    //从淘宝获取 生成相关的关键词
    public static function taobaoKeyWords($keyWords){
        if(empty($keyWords) || strlen($keyWords)<=0){
            echo "关键词不能为空";
            return ;
        }
        $keyConfig=require ('apps/config/keyConfig.php');
        $url=sprintf($keyConfig['taoBaoKeyWords'],$keyWords);
        $parameter = [
            'is_proxy' => true,
            'isHttps'=>true,
        ];
        $keyArrayJsonObj = curlData('GET',$url,$parameter);
        $keyArrayJson=$keyArrayJsonObj['body'];
        if(!empty($keyArrayJson)){
            $keyArray=json_decode($keyArrayJson);
            if(is_array($keyArray) && isset($keyArray['result'])){
                return $keyArray['result'];
            }else{
                return array();
            }
        }else{
            return array();
        }
    }
    
    //淘宝评论
    public function TaobaoCommentList($itemId,$page=1){
        if(!is_numeric($itemId) || !is_numeric($sellerId)){
            echo "不是数字";
            return ;
        }
        $keyConfig=require ('apps/config/keyConfig.php');
        $url=sprintf($keyConfig['comment_list'],$itemId,$page);
        $parameter = [
            'is_proxy' => true,
            'isHttps'=>true,
        ];
        $commentListArrayJsonObj = curlData('GET',$url,$parameter);
        $commentListArrayJson=trim($commentListArrayJsonObj['body']);
        if(stripos($commentListArrayJson, "jsonp1966(")>=0){
            $commentListArrayJson=substr($commentListArrayJson, strlen("jsonp1966("),strripos($reasonListArrayJson,")")-strlen("jsonp1966("));
        };
        if(!empty($commentListArrayJson)){
            $commentListArray=json_decode($commentListArrayJson);
            if(is_array($commentListArray) && isset($commentListArray['rateDetail']) ){
                return $commentListArray['rateDetail'];
            }else{
                return array();
            }
        }else{
            return array();
        }
    }
    
    
    //问大家
    public function AskEverybodyList($itemId,$sellerId){
        if(!is_numeric($itemId) || !is_numeric($sellerId)){
            echo "不是数字";
            return ;
        }
        $keyConfig=require ('apps/config/keyConfig.php');
        $url=sprintf($keyConfig['askEverybody_list'],$itemId,$sellerId);
        $parameter = [
            'is_proxy' => true,
            'isHttps'=>true,
        ];
        $AskEverybodyListArrayJsonObj = curlData('GET',$url,$parameter);
        $AskEverybodyListArrayJson=trim($AskEverybodyListArrayJsonObj['body']);
        if(stripos($AskEverybodyListArrayJson, "json_tbc_rate_summary(")>=0){
            $AskEverybodyListArrayJson=substr($AskEverybodyListArrayJson, strlen("json_tbc_rate_summary("),strripos($reasonListArrayJson,")")-strlen("json_tbc_rate_summary("));
        };
        if(!empty($AskEverybodyListArrayJson)){
            $AskEverybodyListArray=json_decode($AskEverybodyListArrayJson);
            if(!empty($AskEverybodyListArray)  && isset($AskEverybodyListArray['data']) ){
                return $AskEverybodyListArray['data'];
            }else{
                return array();
            }
        }else{
            return array();
        }
    }
    
}

?>