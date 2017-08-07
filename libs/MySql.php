<?php

/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 07.08.17
 * Time: 12:41
 */
class MySql extends Db
{
    public function __construct ()
    {
        if ($connect = mysqli_connect(HOST, USER, PASSWORD_SQL, DB))
        {
            parent::__construct($connect);
        }
        else
        {
            throw new Exception('Could not connect');
        }
    }
    
    private function quoteSimpleTableName ($name)
    {
        return strpos($name, '`') !== false ? $name : '`' . $name . '`';
    }

    private function quoteSimpleColumnsName ($fields)
    {
        foreach ($fields as $key=>$field)
        {
            $key = strpos($key, "`") !== false ? $key : "`" . $key . "`";
            $aFields[$key] = $field;
        }
        return $aFields;
    }
}