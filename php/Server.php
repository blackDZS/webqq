<?php

include './dbconfig.php';
class Server
{
    protected $_request = null;
    protected $_responce = null;
    protected $conn = null;

    public function __construct()
    {;
    }

    public function __destruct()
    {;
    }

    public function makeSuccessResponce($message, $data)
    {
        $this->_responce = array(
            "success" => true,
            "message" => $message,
            "data" => $data
        );
    }

    public function makeFaliureResponce($message, $data)
    {
        $this->_responce = array(
            "success" => false,
            "message" => $message,
            "data" => $data
        );
    }

    public function getResponse()
    {
        return $this->_responce;
    }

    public function makeRequest($objrequest)
    {
        $this->_request = $objrequest;
    }

    public function run()
    {
        // var_dump("asd");
    }

    public function openConnection()
    {
        $connstr = "host=" . HOST . " port=" . PORT . " dbname=" . DBNAME . " user=" . USERNAME . " password=" . PASSWORD . "";
        $this->conn = @pg_connect($connstr);

        if (!$this->conn) {
            $this->makeFaliureResponce("无法连接数据库", "");
            return false;
        }
        return true;
    }

    public function closeConnection()
    {
        pg_close($this->conn);
        $this->conn = null;
    }
}
