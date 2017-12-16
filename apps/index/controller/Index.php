<?php
namespace app\index\controller;

use app\base\BaseController;
use app\index\model\KeyWords;

// require_once 'apps/utils/function.php';
class Index extends BaseController
{

    public function index()
    {
       
        
        return $this->fetch('index');
    }

  
    
   
    public function indexcate(){
        $id = isset($_REQUEST['id']) && ! empty($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "";
        if(empty($id)){
            echo "<script>window.location.href = /</script>";
        }
        $indexModel= new \app\index\model\indexModel();
        $cate = $indexModel->getDataForId($id);
        //if($cate['type']==1){
        //    echo "<script>alert('11');window.location.href = '".$cate['url']."'</script>";
        //    return ;
        //}
        
        $this->assign("cate_name",$cate['cate_name']);
        $this->assign("indexCateId",$cate['id']);
     
        return $this->fetch('itemcate');
    }
    
    public function getIndexCateUrl(){
        $id = isset($_REQUEST['id']) && ! empty($_REQUEST['id']) && is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : "";
        if(empty($id)){
            $array=['Code'=>-1,
                'msg'=>"id not empty",
            ];
            echo json_encode($array);
        }
        $indexModel= new \app\index\model\indexModel();
        $cate = $indexModel->getDataForId($id);
        //var_dump($cate);
        if($cate && is_array($cate) && count($cate)>0){
            $array=['Code'=>0,
                'url'=>$cate['url'],
                'type'=>$cate['type'],
            ];
            echo json_encode($array);
        }else{
            $array=['Code'=>-1,
                'msg'=>"data empty",
            ];
            echo json_encode($array);
        }
        
    }
    
}

?>
