<?php

class Database
{
    private $host = "localhost";
    private $name = "abdotask";
    private $user = "abdotask";
    private $pass = "nhzh1SWNSKvFZ8A5";
    public $con;

    public function dbConnection()
    {
        $this->con = null;
        try {
            $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->name, $this->user, $this->pass);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Database Connection error: " . $exception->getMessage();
        }

        return $this->con;
    }
}

?>
