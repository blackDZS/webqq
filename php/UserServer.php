<?php
 //处理用户的登录和注册

include_once './Server.php';

class UserServer extends Server
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
        switch ($this->_request->type) {
            case "USER_LOGIN":
                $this->Login();
                break;
            case "USER_REGISTER":
                $this->Register();
                break;
        }
    }

    public function Login()
    {
        // var_dump("login");
        $data = $this->_request->params;
        $username = $data->username;
        $password = $data->password;
        $sql = "SELECT count(1) FROM users WHERE username=$1 AND password=$2";
        $result = @pg_query_params($this->conn, $sql, array(
            $username,
            $password
        ));
        $row = @pg_fetch_row($result, 0);
        if ((int)$row[0] == 0) {
            $this->makeFaliureResponce("用户不存在", "");
        } elseif ((int)$row[0] == 1) {
            $sql = "SELECT username FROM users WHERE id IN(
                        SELECT user2 FROM qq_friendship WHERE user1 IN(
                            SELECT id FROM users WHERE username='$username'
                        )
                    )";

            $result = @pg_query($this->conn, $sql);
            $row = @pg_fetch_all($result);
            $this->makeSuccessResponce("成功登录", $row);
        }
        @pg_free_result($result);
        return true;
    }

    public function Register()
    {
        $data = $this->_request->params;
        $username = $data->username;
        $password = $data->password;
        $email = $data->email;
        $relname = $data->realname;
        $mobile = $data->mobile;

        $sql = "SELECT count(1) FROM users WHERE username='$username'";
        $result = @pg_query($this->conn, $sql);
        $row = @pg_fetch_row($result, 0);
        if ((int)$row[0] == 1) {
            $this->makeFaliureResponce("该用户名已经存在，请更换用户名", "");
        } else {
            $sql = "INSERT INTO users(username, password, email, realname, mobile) VALUES ($1, $2, $3, $4, $5);";
            $result = @pg_query_params($this->conn, $sql, array(
                $username, $password, $email, $relname, $mobile
            ));
            $sql = "SELECT count(1) FROM users WHERE username='$username'";
            $result = @pg_query($this->conn, $sql);
            $row = @pg_fetch_row($result, 0);
            if ($row[0] == 1) {
                $this->makeSuccessResponce("成功注册", "");
            } else {
                $this->makeFaliureResponce("系统出错", "");
            }
        }
        return true;
    }
}
