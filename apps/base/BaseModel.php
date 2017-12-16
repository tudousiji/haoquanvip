<?php
namespace app\base;

class BaseModel
{

    // protected $table;
    protected $keyConfig;

    function __construct()
    {
        /*
         * if($this->table==null){
         * $this->table = require('apps/config/tableConfig.php');
         * //var_dump($this->table);
         * }
         */
        if ($this->keyConfig == null) {
            $this->keyConfig = require ('apps/config/keyConfig.php');
            //var_dump($this->keyConfig['keyWordCollectionPageSize']);
        }
    }
}

?>