<?php

namespace app\components;

use Yii;

class DbHelper
{
    public static function indexKeyName($tableName, $key)
    {
        $tableName = Yii::$app->db->quoteSql($tableName);
        $tableName = Yii::$app->db->schema->unquoteSimpleTableName($tableName);
        return $tableName . '_' . $key . '_idx';
    }

    public static function foreignKeyName($tableName, $key)
    {
        $tableName = Yii::$app->db->quoteSql($tableName);
        $tableName = Yii::$app->db->schema->unquoteSimpleTableName($tableName);
        return $tableName . '_' . $key . '_fkey';
    }

}