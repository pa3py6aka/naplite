var RecipeView = RecipeView || {};
RecipeView = (function () {
    var Listen = function () {
        $('#personsCount').on('change', function (e) {
            var $input = $(this);
            var count = Number($(this).val());
            $input.prop('disabled', true);
            $.each($('li.ingredient span.value'), function (k, item) {
                var $item = $(item);
                var defValue = Number($item.attr('data-default'));
                var result = (defValue * count).toFixed(2);
                if (result[result.length - 1] === '0') {
                    result = result.substring(0, result.length - 1);
                }
                if (result[result.length - 2] === '.' && result[result.length - 1] === '0') {
                    result = result.substring(0, result.length - 2);
                }
                $item.html(result);
            });
            $input.prop('disabled', false);
            $('#portionsWord').html(NaPlite.public.pluralize(count, ['порцию', 'порции', 'порций']));
        });

        $('[data-link=goToComments]').on('click', function () {
            NaPlite.public.scrollTo($('#commentsBlock'));
        });

        $(document).on('click', '[data-link=addComment]', function (e) {
            $('#commentForm_' + $(this).attr('data-n')).yiiActiveForm('submitForm');
        });
    };

    function init() {
        Listen();
    }

    return {
        init: init
    };
})();

window.addEventListener("load", RecipeView.init);