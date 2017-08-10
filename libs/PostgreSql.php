<?php

/**
 * User: yevhen
 * Date: 08.08.17
 * Time: 14:13
 */
class PostgreSql extends Db
{
    private $dbh;
    
    public function __construct ()
    {
        if ($this->dbh = new PDO('pgsql:host='.HOST.'; dbname='.DB.'; user='.USER_PG.'; password='.PASSWORD_PSQL))
        {
            parent::__construct($this->dbh);
        }
        else
        {
            throw new Exception('Postgresql database error');
        }
    }

    public function selectPdo ($table, $arrSelect, $params)
    {
        return parent::selectPdo($this->quoteSimpleTableName($table), $arrSelect, $params);
    }

    public function insertPdo ($table, $params)
    {
        return parent::insertPdo($this->quoteSimpleTableName($table), $params);
    }

    public function updatePdo ($table, $params, $condition)
    {
        return parent::updatePdo($this->quoteSimpleTableName($table), $params, $condition);
    }

    public function deletePdo ($table, $params)
    {
        return parent::deletePdo($this->quoteSimpleTableName($table), $params);
    }

    private function quoteSimpleTableName ($name)
    {
        return strpos($name, '"') !== false ? $name : '"' . $name . '"';
    }

}