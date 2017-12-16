<?php
namespace app\utils;

class TableUtils
{

    // 静态变量保存全局实例
    private static $_instance = null;

    private $table = null;

    // 私有构造函数，防止外界实例化对象
    private function __construct()
    {}

    // 私有克隆函数，防止外办克隆对象
    private function __clone()
    {}

    // 静态方法，单例统一访问入口
    static public function getInstance()
    {
        if (is_null(self::$_instance) || ! isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->table = require ('apps/config/tableConfig.php');
        }
        return self::$_instance;
    }

    public static function getTableDetails($tabname, $tableField = "")
    {
        if (! isset($tableField) || (isset($tableField) && empty($tableField)))
            return TableUtils::getInstance()->table[$tabname]['table_name'];
        return TableUtils::getInstance()->table[$tabname]['table_field'][$tableField];
    }
}

?>