$(function () {
    var main = $('.search-add-role-form input[name=name]').focus();
    var list = $('ul.role-list').keySelect();
    var createBtn = $('.search-add-role-form input[type=submit]');
    var oldName = null;
    main.keyup(function () {
        var name = main.val().trim();
        if (name !== '') {
            if (name !== oldName) { // 输入框内容有变
                createBtn.hide();
                $.get(G.ROOT_URL+'role', {keyword:name}, function (ret) {
                    if (ret.length > 0) {
                        list.html($.map(ret, function (v) {
                            return '<li><a href="'+G.ROOT_URL+'role/'+v.id+'">'+v.name+'</a></li>';
                        }).join('')).show();
                        list.reset();
                        if (ret[0].found==1) {
                            createBtn.hide();
                        } else {
                            createBtn.show();
                        }
                    } else {
                        list.hide();
                        createBtn.show();
                    }
                }, 'json');
            }
        } else {
            list.hide();
        }
        oldName = name;
    }).keydown(function (e) {
        switch (e.keyCode) {
            case 38:
                list.up();
                break;
            case 40:
                list.down();
                break;
            case 13:
                e.preventDefault();
                window.location.href = list.currentNode().find('a').attr('href');
                return false;
                break;
            default:
                list.reset();
                break;
        }
    });
});