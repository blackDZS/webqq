Dlglogin = function (opts) {
    var me = this;

    me._usernameID = uuid();
    me._passwordID = uuid();
    me._dlg = $("#" + opts.div).html(
        "<label>用户名</label><br>"
        + "<input id='" + me._usernameID + "' type='text' class='ui-corner-all' /><br>"
        + "<label>密码</label><br>"
        + "<input id='" + me._passwordID + "' type='password' class='ui-corner-all' /><br>"
        + "<a href='#' id='toRegister'>没有账号？</a>"
    ).dialog({
        height: 500,
        width: 400,
        modal: true,
        buttons: [
            {
                text: "登录",
                click: function () {
                    me._onLogin()
                }
            },
            {
                text: "取消",
                click: function () {
                    me._dlg.dialog("close");
                }
            }
        ]
    });
};

Dlglogin.prototype._onLogin = function () {
    // alert("login");
    var me = this;

    Connector({
        data: {
            type: "USER_LOGIN",
            params: {
                "username": $("#" + me._usernameID).val(),
                "password": $("#" + me._passwordID).val()
            }
        },

        success: function (json) {
            me._dlg.dialog("close");
            alert(json["message"]);
        },

        error: function (json) {

        }
    });

}