<?php

/**
 * User: yevhen
 * Date: 07.08.17
 * Time: 11:39
 */
class Db extends Sql
{
    private $dbh;
    private $aParams = [];
    private $aValues = [];
    private $aWhere = [];
    private $aValuesWhere = [];

    public function __construct ($db)
    {
        $this->dbh = $db;
    }

    public function selectPdo ($table, $params)
    {
        $this->params($params);

        $sql = parent::select()->from($table)->where($this->aParams)->execute();

        $STH = $this->dbh->prepare($sql);

        $STH->execute($this->aValues);

        $row = $STH->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function insertPdo ($table, $params)
    {
        $this->params($params);

        $sql = parent::insert()->from($table)->values($this->aParams)->execute();

        $STH = $this->dbh->prepare($sql);

        if ($STH->execute($this->aValues))
        {
            return SUCCESS_MESAGE.' INSERT';
        }
        
    }

    public function updatePdo ($table, $params, $condition)
    {
        $this->params($params, $condition);

        $sql = parent::update()->from($table)->set($this->aParams)->where($this->aWhere)->execute();

        $STH = $this->dbh->prepare($sql);

        if ($STH->execute($this->aValues))
        {
            return SUCCESS_MESAGE.' UPDATE';
        }
    }

    public function deletePdo ($table, $params)
    {
        $this->params($params);

        $sql = parent::delete()->from($table)->where($this->aParams)->execute();

        $STH = $this->dbh->prepare($sql);

        if ($STH->execute($this->aValues))
        {
            return SUCCESS_MESAGE.' DELETE';
        }

    }

    private function params ($params, $condition = null)
    {
        foreach ($params as $key=>$value)
        {
            $this->aParams[$key] = ':'.$this->deleteQuote($key);
            $this->aValues[$this->deleteQuote($key)] = $value;
        }

        if (!empty($condition))
        {
            $i = 1;
            foreach ($condition as $key=>$value)
            {
                $this->aWhere[$key] = ':'.$this->deleteQuote($key).$i;
                $this->aValuesWhere[$this->deleteQuote($key).$i] = $value;
                $i++;
            }
            $this->aValues = array_merge($this->aValues, $this->aValuesWhere);
        }
    }

    private function deleteQuote ($name)
    {
        return strpos($name, '`') !== false ? str_replace('`', '', $name) : $name;
    }



}