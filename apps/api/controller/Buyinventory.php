<?php
namespace app\api\controller;
use app\tableUtils\buyinventoryUtils;
use app\base\BaseController;
use app\api\model\articleModel;
use app\tableUtils\buyinventoryTagsUtils;

class Buyinventory  extends BaseController{
    private $maxRepeatCount=30;
    public function getCateList(){
        
        $utils= new buyinventoryUtils();
        $list = $utils->getCateList();
        echo json_encode($list);
    }
    
    
    /* public function addbuyInventoryItem(){
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        $jsonObj = json_decode($json,true);
        $contentId=$jsonObj['contentId'];
        $data=$jsonObj['data'];
        $cate_id=$jsonObj['cateId'];
        $utils= new buyinventoryUtils();
        $item = $utils->getItemForContentId($contentId);
        if($item==null){
            $array=['contentId'=>$contentId,
                'cate_id'=>$cate_id,
                'data'=>json_encode($data),
            ];
            if(isset($jsonObj['keywords']) && !empty($jsonObj['keywords'])){
                $array['keywords']=$jsonObj['keywords'];
            };
            $utils->addbuyInventoryItem($array);
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
                $jsonKeyValConfig['msg']=>"成功",
                $jsonKeyValConfig['Code']=>0,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($array);
        }else{
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>"数据已经存在",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
        }
    } */
    
    
    public function checkEffectiveContentIdList(){
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        //$json='{"data": ["200280281051", "200255392994", "200209484457", "200247630794", "200349711555", "200199543066", "200320425359", "200132834634", "200161549393", "200168580985", "200309649589", "200253725242", "200283283699", "200289773602", "200288548968", "200210651116", "200245592868", "200330581025", "200243757959", "200254129002", "200227123923", "200319918101", "200220609243", "200155127819", "200233811677", "200318488178", "200230524685", "200332859536", "200304784052", "200321166747", "200159839031", "200214445007", "200354305795", "200329156487", "200252153131", "200311250446", "200367137924", "200322501047", "200198497344", "200271966483", "200321245791", "200278551147", "200162083533", "200233629729", "200297426056", "200187976746", "200164765352", "200295190880", "200159684299", "200328345929", "200328562037", "200313359080", "200239818959", "200201678008", "200280698066", "200349062572", "200180423177", "200281114860", "200241592818", "200260594953", "200171834942", "200365906535", "200199495665", "200191244438", "200187159942", "200229394801", "200220680900", "200210034536", "200162784837", "200313461053", "200220779088", "200289123741", "200196119401", "200328607026", "200200458357", "200192374716", "200192557072", "200315593291", "200224760665", "200370719660", "200245067552", "200195060954", "200246095225", "200347881189", "200204016370", "200168120077", "200180838674", "200207167644", "200283318801", "200155778614", "200156881479", "200227221063", "200260406775", "200354181532", "200216067994", "200300992737", "200210400835", "200223318530", "200338462611", "200161538415", "200306630075", "200308114032", "200273498265", "200198415632", "200210521015", "200301092576", "200285394407", "200237055540", "200189528435", "200309622555", "200321062666", "200168629332", "200266514178", "200261582251", "200254796247", "200254395293", "200197939312", "200343681438", "200352544173", "200261495680", "200280875166", "200345456847", "200183965911", "200328137540", "200266258412", "200205116901", "200314786007", "200230501917", "200342262696", "200284022375", "200216662809", "200318375281", "200324830416", "200291268136", "200263934845", "200269037041", "200214352219", "200356765942", "200155471229", "200278059891", "200171446834", "200303634131", "200220466855", "200291361348", "200362156884", "200301850754", "200167403126", "200322699566", "200233391931", "200204169846", "200318641488", "200328523161", "200325532233", "200329622195", "200354845095", "200237043591", "200260696892", "200300032787", "200180680296", "200168454576", "200210939388", "200233752902", "200360774674", "200150413609", "200298860597", "200172355932", "200199677418", "200208951614", "200274703149", "200256737257", "200333717411", "200208126063", "200258417757", "200297477386", "200181988090", "200285406945", "200156213855", "200301886709", "200162437915", "200174567954", "200211089111", "200319916943", "200197332086", "200299711869", "200274819813", "200324794506", "200313154266", "200365794332", "200271127231", "200252353103", "200290349440"]}';
       
        $jsonObj = json_decode($json,true);
        $data=$jsonObj['data'];
        $cateId=$jsonObj['cateId'];
        $page=$jsonObj['page'];
        $contentId=implode(',',$data);
        
        $utils= new buyinventoryUtils();
        $list = $utils->checkEffectiveContentIdList($contentId);
        
        $utils= new buyinventoryUtils();
        $cate = $utils->getCateId($cateId);
        $isNextpage=false;
        if($cate['isrepeatover']==0 && $cate['maxpage']<=0){
            $isNextpage=$this->isrepeatover($utils, $data);
        }else if($cate['isrepeatover']==1){//超过指定数就停止
            $isNextpage=$this->isrepeatover($utils, $data);
        }else if($cate['maxpage']>0){
            if($page>=$cate['maxpage']){
                $isNextpage=false;
            }else {
                $isNextpage=true;
            }
        }else{
            $isNextpage=false;
        }
       
        
        $array=['data'=>$list,
            'isNextpage'=>$isNextpage,
        ];
        echo json_encode($array);
    }
    
    private function isrepeatover($utils,$data){
       
        $repeatCount=0;
        $isNextpage=true;
        for($i=0;$i<count($data);$i++){
            $item = $utils->getItemForContentId($data[$i]);
            if($item!=null){
                $repeatCount++;
            }
            if($repeatCount>=$this->maxRepeatCount){
                $isNextpage=false;
                break;
            }
        }
        
        return $isNextpage;
    }
    
    /**
     * 添加ContentId
     */
    public function addContentId(){
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        
        $jsonObj = json_decode($json,true);
        $dataObj=$jsonObj['data'];
        $cateId=$jsonObj['cateId'];
        $page=$jsonObj['page'];
        $contentId=$jsonObj['contentId'];
        
        
        $size=count($dataObj);
        $utils=new articleModel();
        if($size>0){
            $ids="";
            for($i=0;$i<$size;$i++){
                $ids.=$dataObj[$i];
                if($i!=$size-1){
                    $ids.=",";
                }
            }
            
            $list = $utils->checkRepeatContentId($ids);
            
            $listnew = [];
            $listSize=count($list);
            for($i=0;$i<$listSize;$i++){
                $listnew[$i]=strval($list[$i]['contentId']);
            }
            //array_column($list, 'contentId');
           
            $dataObj =array_diff($dataObj, $listnew);
           
        }
       
        
        foreach ($dataObj as  $value){
            //$contentId=$dataObj[$i];
           
            $array=['contentId'=>$value,'cateId'=>$cateId,'page'=>$page,'parentContentId'=>$contentId];
            $utils->addContentId($array);
        }

        
        $utils= new buyinventoryUtils();
        $cate = $utils->getCateId($cateId);
        $isNextpage=false;
        if($cate['isrepeatover']==0 && $cate['maxpage']<=0){
            $isNextpage=$this->isrepeatover($utils, $data);
        }else if($cate['isrepeatover']==1){//超过指定数就停止
            $isNextpage=$this->isrepeatover($utils, $data);
        }else if($cate['maxpage']>0){
            if($page>=$cate['maxpage']){
                $isNextpage=false;
            }else {
                $isNextpage=true;
            }
        }else{
            $isNextpage=false;
        }
        
        
        $array=[
            'isNextpage'=>$isNextpage,
        ];
        echo json_encode($array);
    }
    
    
    
    /**
     * 获取未采集的ContentId
     */
    public function getContentIdList(){
        $utils =new buyinventoryUtils();
        $list = $utils->getContentIdList();
        echo json_encode($list);
    }
    
    /**
     * 添加buyinventory_item_info
     */
    public function addBuyinventoryItem(){
        
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        
        $jsonObj = json_decode($json,true);
        $dataObj=$jsonObj['data'];
        $cateId=$jsonObj['cate_id'];
        $contentId=$jsonObj['contentId'];
        //$keywords=$jsonObj['keywords'];
        //$contentId=$jsonObj['contentId'];
        $utils =new buyinventoryUtils();
        
        if(empty($dataObj)){
            $utils->updateContentIdStatus($contentId,-1);
        }else{
            $utils= new buyinventoryUtils();
            $item = $utils->getItemForContentId($contentId);
            
            if($item==null){
                $utils->updateContentIdStatus($contentId,1);
                
                $title=$dataObj['title'];
                $subTitle=$dataObj['subTitle'];
                $summary=$dataObj['summary'];
                $gmtCreate=$dataObj['gmtCreate'];
                $readCount=$dataObj['readCount'];
                $richText=null;
                $modules=null;
                $products=null;
                $type=0;//0是采集失败,1是richText有值，2是modules有值，3是商品列表（可能包含视频）
                if(isset($dataObj['richText'])){
                    $richText=$dataObj['richText'];
                    $type=1;
                }
                if(isset($dataObj['modules']) && !empty($dataObj['modules'])){
                    $modules=$dataObj['modules'];
                    $type=2;
                }
                if(isset($dataObj['products']) && !empty($dataObj['products'])){
                    $products=$dataObj['products'];
                    $type=3;
                }
                
                $insertData=[
                    'title'=>$title,
                    'subTitle'=>$subTitle,
                    'summary'=>$summary,
                    'gmtCreate'=>$gmtCreate,
                    'readCount'=>$readCount,
                    'type'=>$type,
                    'update_time'=>time(),
                    'contentId'=>$contentId,
                    'cate_id'=>$cateId,
                ];
                if(!empty($richText) && $richText!=null){
                    $insertData['richText']=json_encode($richText);
                }
                if(!empty($modules) && $modules!=null){
                    $insertData['modules']=json_encode($modules);
                }
                if(!empty($products) && $products!=null){
                    $insertData['products']=json_encode($products);
                }
                //print_r($json);return ;
                $utils->addBuyinventoryItem($insertData);
            }else{
                $data=[
                    $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                    $jsonKeyValConfig['msg']=>"数据已经存在",
                    $jsonKeyValConfig['Code']=>-1,//
                ];
                //var_dump(isset($_POST['data']));
                echo json_encode($data);
                return ;
            }
            
        }
        
        $array=[
            $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
            $jsonKeyValConfig['msg']=>"成功",
            $jsonKeyValConfig['Code']=>0,//
        ];
        //var_dump(isset($_POST['data']));
        echo json_encode($array);
        
    }
    
    
    public function addBuyinventoryTags(){
        $json = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
        $jsonKeyValConfig=require_once 'apps/config/jsonKeyValConfig.php';
        
        if(empty($json)){
            $data=[
                $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Fail'],
                $jsonKeyValConfig['msg']=>":数据为空",
                $jsonKeyValConfig['Code']=>-1,//
            ];
            //var_dump(isset($_POST['data']));
            echo json_encode($data);
            return ;
        }
        $jsonObj = json_decode($json,true);
        $dataObj=$jsonObj['data'];
        $cateId=$jsonObj['cateId'];
        $contentId=$jsonObj['contentId'];
        $page=$jsonObj['page'];
        
        
        $size=count($dataObj);
        $utils=new buyinventoryTagsUtils();
        for($i=0;$i<$size;$i++){
            $tagName=$dataObj[$i];
            $tagsMd5=md5($tagName);
            $md5=$utils->getBuyinventoryTagsMd5($tagsMd5);
            
             if($md5 == null){
                $array=[
                    'tag_name'=>$tagName,
                    'md5'=>$tagsMd5,
                    'page'=>$page,
                    'contentId'=>$contentId,
                    'cateId'=>$cateId,
                    'update_time'=>time(),
                ];
                $utils->addBuyinventoryTags($array);
            }else{
                continue;
            } 
            
        }
        
        $array=[
            $jsonKeyValConfig['Status']=>$jsonKeyValConfig['Success'],
            $jsonKeyValConfig['msg']=>"成功",
            $jsonKeyValConfig['Code']=>0,//
        ];
        //var_dump(isset($_POST['data']));
        echo json_encode($array);
    }
    
    
}