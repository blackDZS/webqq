Dlgregister = function (opts) {
    var me = this;

    me._usernameID = uuid();
    me._passwordID = uuid();
    me._repasswordID = uuid();
    me._emailID = uuid();
    me._realnameID = uuid();
    me._mobileID = uuid();
    me._dlg = $("#" + opts.div).html(
        "<label>用户名</label><br>"
        + "<input id='" + me._usernameID + "' type='text' class='ui-corner-all' /><br>"
        + "<label>密码</label><br>"
        + "<input id='" + me._passwordID + "' type='password' class='ui-corner-all' /><br>"
        + "<label>重复密码</label><br>"
        + "<input id='" + me._repasswordID + "' type='password' class='ui-corner-all' /><br>"
        + "<label>邮箱</label><br>"
        + "<input id='" + me._emailID + "' type='email' class='ui-corner-all' /><br>"
        + "<label>真实姓名</label><br>"
        + "<input id='" + me._realnameID + "' type='text' class='ui-corner-all' /><br>"
        + "<label>手机号码</label><br>"
        + "<input id='" + me._mobileID + "' type='number' class='ui-corner-all' /><br>"
    ).dialog({
        height: 500,
        width: 400,
        modal: true,
        buttons: [
            {
                text: "注册",
                click: function () {
                    if ($("#" + me._usernameID).val() === ""
                        || $("#" + me._passwordID).val() === ""
                        || $("#" + me._repasswordID) === ""
                        || $("#" + me._emailID).val() === ""
                        || $("#" + me._realnameID) === ""
                        || $("#" + me._mobileID).val() === "") {
                        alert("请完整填写所有字段");
                    } else if ($("#" + me._passwordID).val() !== $("#" + me._repasswordID).val()) {
                        alert("两次密码不一致！")
                    } else {
                        me._onRegister();
                    }
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

Dlgregister.prototype._onRegister = function () {
    // alert("login");
    var me = this;

    Connector({
        data: {
            type: "USER_REGISTER",
            params: {
                "username": $("#" + me._usernameID).val(),
                "password": $("#" + me._passwordID).val(),
                "email": $("#" + me._emailID).val(),
                "realname": $("#" + me._realnameID).val(),
                "mobile": $("#" + me._mobileID).val()
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