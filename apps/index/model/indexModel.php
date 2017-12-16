<?php
namespace app\index\model;

use app\utils\NetUtils;
use think\Db;
use app\base\BaseModel;
use app\utils\TableUtils;
class indexModel{
    public function getDataForId($id=1){
        $tableUtils = new \app\tableUtils\indexcateUtils();
        return $tableUtils->getIndexCateForId($id);
        
    }
    
}
?>