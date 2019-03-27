<?php

class Server
{
    protected $_request = null;
    protected $_responce = null;

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
}
