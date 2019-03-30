var username = "";

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

    username = $("#" + me._usernameID).val();
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
            $('nav').removeClass("hidden");
            $('div').removeClass("hidden");
            // alert(json["message"]);
            var friends = json["data"];
            // console.log(friends[0]["username"]);
            // console.log(friends.length);
            for (var i = 0; i < friends.length; i++) {
                $('ul#friends_list').append(function () {
                    return '<li class="nav-item" id="friends_' + friends[i]["username"] + '">' +
                        '<a class="nav-link" href="#">' +
                        '<span data-feather="file-text">' + friends[i]["username"] + '</span><br>' +
                        '</a>' +
                        '</li>' +
                        '<br>';
                });
            }

            me._start_chart();
        },

        error: function (json) {

        }
    });
}

Dlglogin.prototype._start_chart = function () {
    // $("li.nav-item").on(, function () {

    // });
    var me = this;
    $("li.nav-item").click(function (e) {
        e.preventDefault();
        // alert($(e.target).html());
        var cur_fri = $(e.target).html()
        $("#current_friend").html(cur_fri);
        $("tbody").empty();
        me._ask_message();
    });
}

Dlglogin.prototype._ask_message = function () {
    var me = this;
    Connector({
        data: {
            type: "MESSAGEASK_" + username + "-" + $("#current_friend").text(),
            params: {

            }

        },
        success: function (json) {
            var message = json["data"]
            // alert(message);
            console.log(message);
            me._apdate_message_content(message);
        },
        error: function () {

        }
    })
};

Dlglogin.prototype._apdate_message_content = function (message) {
    var me = this;
    for (var i = 0; i < message.length; i++) {
        $("tbody").append(function () {
            return '<tr>'
                + '<td class="" id="message_' + i + '">' + message[i]["message"] + '</td>'
                + '</tr>'
        });
        if (message[i]["fromuser"] == username) {
            $("td#message_" + i).addClass("send_message");
        } else {
            $("td#message_" + i).addClass("receive_message");
        }
    };

    $("tbody").append(function () {
        return '<textarea id="messages" cols="165" rows="5" style="overflow:hidden, width=100%;"></textarea>' +
            '<button type="button" id="send" class="btn btn-primary btn-lg btn-block">发送</button>'
    });

    $("button#send").click(function (e) {
        e.preventDefault();
        me._send_message();
    });
}

Dlglogin.prototype._send_message = function () {
    var me = this;
    if ($("textarea#messages").val() == "") {
        alert("发送内容不能为空");
    } else {
        Connector({
            data: {
                type: "SENDMESSAGE_" + username + "-" + $("#current_friend").text(),
                params: {
                    "message": $("textarea#messages").val()
                }
            },
            success: function () {

            },
            error: function () {

            }
        })
    }
}