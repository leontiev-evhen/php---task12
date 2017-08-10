<?php

class MySql extends Db
{
    private $connect;

    public function __construct ()
    {
        if ($this->connect = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASSWORD_SQL))
        {
            parent::__construct($this->connect);
        }
        else
        {
            throw new Exception('Could not connect');
        }
    }

    public function selectPdo ($table, $arrSelect, $params)
    {
        return parent::selectPdo($this->quoteSimpleTableName($table), $arrSelect, $this->quoteSimpleColumnsName($params));
    }

    public function insertPdo ($table, $params)
    {
        return parent::insertPdo($this->quoteSimpleTableName($table), $this->quoteSimpleColumnsName($params));
    }

    public function updatePdo ($table, $params, $condition)
    {
        return parent::updatePdo($this->quoteSimpleTableName($table), $this->quoteSimpleColumnsName($params), $this->quoteSimpleColumnsName($condition));
    }

    public function deletePdo ($table, $params)
    {
        return parent::deletePdo($this->quoteSimpleTableName($table), $this->quoteSimpleColumnsName($params));
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
?>
