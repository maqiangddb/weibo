$(function () {
    $('#avatar_upload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $('.info img').attr('src', data.result.path);
            $.post(
                '/role_edit',
                {
                    id: $('.role-info').data('id'),
                    field: 'avatar',
                    value: data.result.path
                },
                function (ret) {
                    console.log('ok');
                }
            );
        }
    });
    $('input[name=is_v]').change(function () {
        $.post(
            '/role_edit',
            {
                id: $('.role-info').data('id'),
                field: 'is_v',
                value: $(this).prop('checked') ? 1 : 0
            },
            function (ret) {
                console.log('ok');
            }
        );
    });
});