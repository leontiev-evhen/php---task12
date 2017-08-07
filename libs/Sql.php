<?php 


class Sql
{
    protected $query;
    protected $select;
    protected $insert;
    protected $update;
    protected $delete;
    protected $from;
    protected $values;
    protected $set;
    protected $dbh;
    protected $valueWhere;

    public function __construct($db)
    {
        $this->dbh = $db;
    }


    public function select ($fields)
    {
        if ($this->checkArray($fields))
        {
            if (in_array("*", $fields))
            {
                throw new Exception('Forbidden character');
            }

            $this->select = 'SELECT '.implode(', ', $fields).' FROM ';
            return $this;
        }
    }

    public function insert ()
    {
        $this->insert = 'INSERT INTO ';
        return $this;
    }

    public function update ()
    {
        $this->update = 'UPDATE ';
        return $this;
    }

    public function delete ()
    {
        $this->delete = 'DELETE FROM ';
        return $this;
    }

    public function from ($table, $alias = ' ')
    {
       $this->from = $table.$alias;
       return $this;
    }

    public function where ($condition)
    {
        $this->where = ' WHERE `'.$condition.'` = :value';
        return $this;
    }

    public function valueWhere ($value)
    {
        $this->valueWhere = $value;
        return $this;
    }

    public function set ($fields)
    {
        if ($this->checkArray($fields))
        {
            foreach($fields as $key=>$val) {
                $arr[] = $key.' = '.':'.$val;
            }

            $this->set = ' SET '.implode(' , ', $arr);
            return $this;
        }
    }

    public function values ($set)
    {
        if ($this->checkArray($set))
        {
            foreach ($set as $key=>$value) {
                $aSet[$key] = $this->quoteSimpleColumnName($value);
            }

            $key    = array_keys($aSet);
            $values = array_values($aSet);
            $this->values = ' ('.implode(', ', $key).') VALUES ('.implode(', ', $values).')';
            return $this;
        }
    }

    protected function checkArray ($array)
    {
        if (is_array($array)) {
            return true;
        }
        else
        {
            throw new Exception('argument is not array');
        }
    }

    protected function quoteSimpleColumnName ($name)
    {
        return strpos($name, "'") !== false ? $name : "'" . $name . "'";
    }

    public function execute()
    {
        switch ($this)
        {
            case !empty($this->insert):
                return $this->insert.$this->from.$this->values;

            case !empty($this->select):

                $STH = $this->dbh->prepare($this->select.$this->from.$this->values.$this->where);
                $STH->bindParam(':value', $this->valueWhere);
                $STH->execute();
                $result = $STH->fetchAll(PDO::FETCH_ASSOC);
                return $result;

            case !empty($this->update):
                return $this->update.$this->from.$this->set.$this->where;

            case !empty($this->delete):
                return $this->delete.$this->from.$this->where;
        }
    }

}
?>
