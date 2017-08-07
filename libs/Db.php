<?php

/**
 * User: yevhen
 * Date: 07.08.17
 * Time: 11:39
 */
class Db extends Sql
{
    public function __construct ()
    {
        if ($connect = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASSWORD_SQL))
        {
            parent::__construct($connect);
        }
        else
        {
            throw new Exception('Could not connect');
        }
    }


}