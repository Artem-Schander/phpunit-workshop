<?php
namespace App;

use PDO;

class DB
{
    protected $host;
    protected $db;
    protected $user;
    protected $pass;
    protected $charset;

    protected $dsn;
    protected $pdo;

    public function __construct($host = '127.0.0.1', $db = 'test', $user = 'root', $pass = '', $charset = 'utf8')
    {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pass = $pass;
        $this->charset = $charset;

        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($this->dsn, $this->user, $this->pass, $opt);
    }

    /**
     * @return PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }
    
}
