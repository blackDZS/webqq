<?php


include_once './Server.php';
include_once './dbconfig.php';
include_once './UserServer.php';

$request = json_decode($_REQUEST["request"]);
$type = $request->type;

$_request = explode('_', $type);

// echo $connstr;
$sv = new Server();
$sv->$_REQUEST = $request;

if($_request[0] == "USER"){
    $sv = new UserServer();
}else{
    
}

$sv->makeRequest($request);
$sv->openConnection();
$sv->run();
$sv->closeConnection();
echo json_encode($sv->getResponse());
 