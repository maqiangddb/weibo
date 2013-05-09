$(function () {
    $('#avatar_upload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $('.info img').attr('src', data.result.path);
            $.post(
                '/role_change_avatar',
                {
                    id: $('.role-info').data('id'),
                    src: data.result.path
                },
                function (ret) {
                    console.log('ok');
                }
            );
        }
    });
});