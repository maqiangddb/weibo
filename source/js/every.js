/* 
 * by xc
 */

$(function () {
    $('h1 span.text').naughtyText({range: 12});
    
    // 评论
    $('.comment-form').each(function () {
        var commentForm = $(this);
        var okBtn = commentForm.find('input');
        commentForm.find('textarea').focus(function () {
            commentForm.addClass('on');
        }).focusout(function () {
            if ($(this).val() === '') {
                commentForm.removeClass('on');
            }
        }).keyup(function () {
            if ($(this).val() == '') {
                console.log('dis');
                okBtn.prop('disabled', true);
            } else {
                console.log('en');
                okBtn.prop('disabled', false);
            }
        });
    });
});