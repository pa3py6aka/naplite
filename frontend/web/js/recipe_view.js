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

        $('[data-link=save-recipe-link]').on('click', function () {
            var $link = $(this);
            var $icon = $link.find('i');
            if ($icon.hasClass('fa-spinner')) {return;}
            var curClass = $icon.hasClass('fa-plus') ? 'fa-plus' : 'fa-minus';
            var recipeId = $link.attr('data-recipe-id');
            $.ajax('/recipes/save-to-user', {
                method: "post",
                dataType: "json",
                data: {recipeId: recipeId},
                beforeSend: function () {
                    $icon.removeClass(curClass);
                    $icon.addClass('fa-spinner');
                },
                success: function(data, textStatus, jqXHR) {
                    if (data.result === 'success') {
                        $link.html(data.html);
                    }
                },
                complete: function () {
                    $icon.removeClass('fa-spinner');
                    $icon.addClass(curClass);
                }
            });
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