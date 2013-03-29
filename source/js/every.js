/* 
 * by xc
 */

$(function () {
    $('h1 span.text').naughtyText({range: 12});
    
    // 评论
    $('.comment-form').each(function () {
        var commentForm = $(this);
        var avatar = commentForm.find('.avatar').hide();
        var okBtn = commentForm.find('.comment-btn').hide();
        commentForm.find('textarea').focus(function () {
            commentForm.addClass('on');
            avatar.show();
            okBtn.show();
        }).focusout(function () {
            if ($(this).val() === '') {
                commentForm.removeClass('on');
                avatar.hide();
                okBtn.hide();
            }
        }).keyup(function () {
            if ($(this).val() == '') {
                okBtn.prop('disabled', true);
            } else {
                okBtn.prop('disabled', false);
            }
        });
    });
});