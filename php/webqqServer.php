<?php


include_once './Server.php';
include_once './dbconfig.php';
include_once './UserServer.php';
include_once './UserMessages.php';

$request = json_decode($_REQUEST["request"]);
$type = $request->type;

$_request = explode('_', $type);
// echo $_request[0];
// echo $connstr;
$sv = new Server();

if($_request[0] == "USER"){
    $sv = new UserServer();
}elseif($_request[0] == "MESSAGEASK"){
    // echo "MESSAGEASK";
    $sv = new UserMessage();
}elseif($_request[0] == "SENDMESSAGE"){
    // echo "SENDMESSAGE";
    $sv = new UserMessage();
}elseif($_request[0] == "FRIENDS"){
    $sv = new UserServer();
    // echo "ADDFRIENDS";
}

$sv->makeRequest($request);
$sv->openConnection();
$sv->run();
$sv->closeConnection();
echo json_encode($sv->getResponse());
 