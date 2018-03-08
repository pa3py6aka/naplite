var RecipeView = RecipeView || {};
RecipeView = (function () {
    var Listen = function () {
        $('#personsCount').on('change', function() {
            updateIngredientsQuantity();
        });

        $('.portions-selector').on('click', 'i', function () {
            var direction = !$(this).index() ? 'up' : 'down';
            var $input = $('#personsCount');
            var count = Number($input.val());
            var result;
            if (direction === 'up') {
                result = count + 1;
            } else {
                result = count - 1;
            }
            if (result < 0) {
                result = 0;
            }
            $input.val(result);
            updateIngredientsQuantity();
        });

        $('[data-link=goToComments]').on('click', function () {
            NaPlite.public.scrollTo($('#commentsBlock'));
        });

        $('[data-link=save-recipe-link]').on('click', function () {
            var $link = $(this);
            var $icon = $link.find('i');
            if ($icon.hasClass('fa-spinner')) {return;}
            var curClass = $icon.hasClass('fa-plus') ? 'fa-plus' : ($icon.hasClass('fa-heart-o') ? 'fa-heart-o' : 'fa-minus');
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
                        if (curClass === 'fa-heart-o') {
                            $('.recipe_stat_buttons').find('[data-link=save-recipe-link]').html(data.html);
                        } else {
                            $link.html(data.html);
                        }
                        $('span[data-role=count]').html('<i class="fa fa-heart-o"></i>' + data.count);
                    }
                },
                complete: function () {
                    $icon.removeClass('fa-spinner');
                    $icon.addClass(curClass);
                }
            });
        });

        $('[data-link="create-photo-report-link"]').on('click', function () {
            $(".modalbox").hide();
            $("#newPhotoReportModal").fadeIn();
        });
        $('#newPhotoReportModal').on('click', '.upload-link', function () {
            $('#photo-report-file-input').click();
        });
        $('#photo-report-file-input').on('change', function (evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            if (FileReader && files && files.length) {
                var fr = new FileReader();
                /*var $btnBlock = $('#newPhotoReportModal').find('.file-upload-block');
                var btnWidth = $btnBlock.width();
                fr.onload = function () {
                    $('#newPhotoReportModal')
                        .find('.photo-report-modal-image')
                        .width(btnWidth)
                        .attr('src', fr.result)
                        .removeClass('hidden');
                    $btnBlock.html('Выбрать другую').width(btnWidth);
                };
                fr.readAsDataURL(files[0]);*/
                var $btnBlock = $('#newPhotoReportModal').find('.upload-link');
                var btnWidth = $btnBlock.width();
                fr.onload = function () {
                    $btnBlock.find('img').remove();
                    $btnBlock.find('i, span').hide();
                    $btnBlock.prepend('<img src="' + fr.result + '" style="width:'+ btnWidth +'px;">');
                    //$btnBlock.html('Выбрать другую').width(btnWidth);
                };
                fr.readAsDataURL(files[0]);
            }
        });
    };

    function updateIngredientsQuantity() {
        var $input = $('#personsCount');
        var count = Number($input.val());
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
    }

    function init() {
        Listen();

        $('.recipe_steps').photobox('.step-photo', {time:0});
        $('.photoreport').photobox('.photo-report-image', {time:0});
    }

    return {
        init: init
    };
})();

window.addEventListener("load", RecipeView.init);