$(document).on('click', '[data-link=addComment]', function (e) {
    var n = $(this).attr('data-n');
    $('#commentform-content-' + n).val(CKEDITOR.instances['commentform-content-' + n].ui.editor.getData());
    $('#commentForm_' + n).yiiActiveForm('submitForm');
}).on('click', '.replyToComment', function (e) {
    var username = $(this).parent().parent().find('[data-username=here]').text(),
        $lastTextarea = $('textarea[name*="content"]').last(),
        id = $lastTextarea.attr('id'),
        val = CKEDITOR.instances[id].ui.editor.getData();
    CKEDITOR.instances[id].ui.editor.setData('<b>' + username + '</b>,&nbsp;' + val);
    NaPlite.public.scrollTo($('.field-' + id));
});

NaPlite.public.SetCKEditor('commentform-content-1');
if ($('#commentform-content-2').length) {
    NaPlite.public.SetCKEditor('commentform-content-2');
}

// CKEDITOR.instances["commentform-content-1"].ui.editor.getData()
