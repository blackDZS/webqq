<?php

include_once '.\Server.php';

class UserMessage extends Server
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function run()
    {
        parent::run();
        if (explode('_', $this->_request->type)[0] == 'MESSAGEASK') {
            $fromto = explode('_', $this->_request->type)[1];
            $from = explode('-', $fromto)[0];
            $to = explode('-', $fromto)[1];
            $this->getMessage($from, $to);
        } elseif (explode('_', $this->_request->type)[0] == 'SENDMESSAGE') {
            $fromto = explode('_', $this->_request->type)[1];
            $from = explode('-', $fromto)[0];
            $to = explode('-', $fromto)[1];
            $message = $this->_request->params->message;
            var_dump($message);
            $this->sendMessage($from, $to, $message);
        }
    }

    protected function getMessage($from, $to)
    {
        $sql = "SELECT fromuser, touser, message FROM qq_message 
                WHERE (fromuser='$from' OR fromuser='$to')
                AND (touser='$from' OR touser='$to');";
        $result = @pg_query($this->conn, $sql);
        $row = @pg_fetch_all($result);
        $this->makeSuccessResponce("得到消息！", $row);
    }

    protected function sendMessage($from, $to, $message)
    {
        $sql = "INSERT INTO qq_message(fromuser, touser, message) VALUES ('$from', '$to', '$message')";
        var_dump($sql);
        $result = @pg_query($this->conn, $sql);
    }
}
