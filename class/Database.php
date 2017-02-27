<?php
/**
 * Created by PhpStorm.
 * User: rberthie
 * Date: 11/25/16
 * Time: 16:29 PM
 */
class database
{
    private $db_name;
    private $engine;
    private $dsn;
    private $db_host;
    private $db_pass;
    private $db_user;
    private $pdo;

    public function __construct($db_name, $db_user, $db_pass, $db_host)
    {
        $this->engine = 'mysql';
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->dsn = $this->engine . ':dbname=' .  $this->db_name . ';host=' .$this->db_host;
    }

    public function getPdo()
    {
        if($this->pdo === null)
        {
            $pdo = new PDO($this->dsn, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }


    public function query($query, $params = false)
    {
        if($this->pdo)
        {
            if ($params)
            {
                $req = $this->pdo->prepare($query);
                $req->execute($params);
            }
            else
            {
                $req = $this->pdo->query($query);
            }
        }
        return $req;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

}