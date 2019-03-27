<?php


include_once './Server.php';

$request = json_decode($_REQUEST["request"]);
// echo $request->type;
$connstr = "host=127.0.0.1 port=5432 dbname=webqq user=postgres password=123456";
$sv = new Server();


// echo $request["type"];

$conn = pg_connect($connstr);

if (!$conn) {
    $sv->makeFaliureResponce("无法连接数据库", "");
    echo json_encode($sv->getResponse());
    exit(1);
}

if ($request->type === "USER_LOGIN") {
    $data = $request->params;
    $username = $data->username;
    $password = $data->password;
    $sql = "SELECT count(1) FROM users WHERE username='$username' AND password='$password'";
    // echo $sql;
    $result = pg_query($conn, $sql);
    $row = @pg_fetch_row($result, 0);
    if ($row[0] == 0){
        $sv->makeFaliureResponce("用户不存在", "");
    }elseif ($row[0] == 1){
        $sv->makeSuccessResponce("成功登录", "");
    }
} elseif ($request->type === "USER_REGISTER") {
    // echo "register";
    $data = $request->params;
    $username = $data->username;
    $password = $data->password;
    $email = $data->email;
    $relname = $data->realname;
    $mobile = $data->mobile;

    $sql = "SELECT count(1) FROM users WHERE username='$username'";
    $result = pg_query($conn, $sql);
    $row = @pg_fetch_row($result, 0);
    if($row[0] == 1){
        $sv->makeFaliureResponce("该用户名已经存在，请更换用户名", "");
    }else{
        $sql = "INSERT INTO users(username, password, email, realname, mobile) VALUES ('$username', '$password', '$email', '$relname', '$mobile');";
        $result = pg_query($conn, $sql);
        $sql = "SELECT count(1) FROM users WHERE username='$username'";
        $result = pg_query($conn, $sql);
        $row = @pg_fetch_row($result, 0);
        if($row[0] == 1){
            $sv->makeSuccessResponce("成功注册", "");
        }
    }
}
// $username = $request["username"];

// $sv->run();
echo json_encode($sv->getResponse());
pg_close($conn);
 