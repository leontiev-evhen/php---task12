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
    protected $where;


    protected function select ($fields = '')
    {
        if (empty($fields))
        {
            $fields = '*';
        }
        else
        {
            if ($this->checkArray($fields))
            {
                $fields = implode(', ', $fields);
            }
        }

        $this->select = 'SELECT '.$fields.' FROM ';
        return $this;

    }

    protected function insert ()
    {
        $this->insert = 'INSERT INTO ';
        return $this;
    }

    protected function update ()
    {
        $this->update = 'UPDATE ';
        return $this;
    }

    protected function delete ()
    {
        $this->delete = 'DELETE FROM ';
        return $this;
    }

    protected function from ($table)
    {
        if ($this->checkIssetField($table))
        {
            $this->from = $table;
            return $this;
        }
    }

    protected function where ($condition)
    {
        if ($this->checkIssetField($condition))
        {
            $this->where = ' WHERE '.key($condition).' = '.$condition[key($condition)];
            return $this;
        }
    }

    protected function set ($fields)
    {
        if ($this->checkArray($fields) && $this->checkIssetField($fields))
        {
            foreach($fields as $key=>$val) {
                $arr[] = $key.' = '.$val;
            }

            $this->set = ' SET '.implode(' , ', $arr);
            return $this;
        }
    }

    protected function values ($set)
    {
        if ($this->checkArray($set) && $this->checkIssetField($set))
        {
            foreach ($set as $key=>$value) {
                $aSet[$key] = $value;
            }

            $key    = array_keys($aSet);
            $values = array_values($aSet);

            $this->values = ' ('.implode(', ', $key).') VALUES ('.implode(', ', $values).')';
            return $this;
        }
    }

    protected function getColumsName ($table)
    {
        if ($this->checkIssetField($table))
        {
            return 'SHOW COLUMNS FROM '.$table;
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

    protected function checkIssetField ($field)
    {
        if (empty($field))
        {
            throw new Exception('Field can not be empty in the function: '.debug_backtrace()[1]['function'].'($arg)');
        }
        else
        {
            return true;
        }
    }

    protected function quoteSimpleColumnName ($name)
    {
        return strpos($name, "'") !== false ? $name : "'" . $name . "'";
    }

    protected function execute()
    {
        switch ($this)
        {
            case !empty($this->insert):
                return $this->insert.$this->from.$this->values;

            case !empty($this->select):
                return $this->select.$this->from.$this->values.$this->where;

            case !empty($this->update):
                return $this->update.$this->from.$this->set.$this->where;

            case !empty($this->delete):
                return $this->delete.$this->from.$this->where;
        }
    }

}
?>
