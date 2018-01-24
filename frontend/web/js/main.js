var NaPlite = {} || NaPlite;
NaPlite = (function () {
    var $messageModal = $('#messageModal');

    var Public = {
        getBoxLoader: function () {
            return $('<div class="box-uploader">\n' +
                         '<div class="box-uploader-bg"></div>\n' +
                         '<img src="/img/spin.gif">\n' +
                         '<div class="box-uploader-progress"></div>' +
                     '</div>');
        },
        pluralize: function (iNumber, aEndings) {
            var sEnding, i;
            iNumber = iNumber % 100;
            if (iNumber>=11 && iNumber<=19) {
                sEnding=aEndings[2];
            }
            else {
                i = iNumber % 10;
                switch (i)
                {
                    case (1): sEnding = aEndings[0]; break;
                    case (2):
                    case (3):
                    case (4): sEnding = aEndings[1]; break;
                    default: sEnding = aEndings[2];
                }
            }
            return sEnding;
        },
        messageModal: function (title, text) {
            $(".modalbox").hide();
            $messageModal.find('H1').html(title).end().find('[data-for=text]').html(text).end().show();
        },
        scrollTo: function ($el) {
            $('html, body').animate({
                scrollTop: $el.offset().top
            }, 800);
        }
    };

    var Listen = function () {
        $(".modalClose").on("click", function (e) {
            $(".modalbox").fadeOut();
        });

        $(".loginButton").on("click", function (e) {
            showModal('loginModal');
            showModal('loginModal');
        });

        $(".regButton").on("click", function (e) {
            showModal('regModal');
        });

        $(".forgotPassLink").on("click", function (e) {
            showModal('forgotPasswordModal');
        });

        $('[data-link=readSeoText]').on('click', function (e) {
            var $seoBlock = $('#categorySeoText');
            if ($seoBlock.hasClass('mini')) {
                $seoBlock.removeClass('mini', 1000);
                $(this).html('<i class="fa fa-refresh"></i>Скрыть');
            } else {
                $seoBlock.addClass('mini', 1000);
                $(this).html('<i class="fa fa-refresh"></i>Читать далее');
            }
        });

        /* Пока только для категорий */
        $(document).on('change', 'select[name=sort-selector]', function (e) {
            var url = $(this).val(),
                $link = $('[data-link=' + $(this).attr('data-for-link') + ']');
            url = url.replace(/\?sort=-?/g, '?sort=-');
            $link.attr('href', url).click();
        });

        $(document).on('change', 'select[name=occasion-selector]', function (e) {
            var url = $(this).val(),
                $link = $('[data-link=' + $(this).attr('data-for-link') + ']');
            $link.attr('href', url).click();
        });
        /* Конец "пока только для категорий" */

        // Для страницы настроек пользователя
        $('#userSettingsPage').on('click', '[data-link=choose-avatar-link]', function (e) {
            $('#userSettingsForm').find('input[type=file][name*=avatar]').click();
        }).on('click', '.upload-file', function (e) {
            e.stopPropagation();
        }).on("change", '.upload-file', function (evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;
            // FileReader support
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    $('[data-image=avatar]').attr('src', fr.result);
                    //document.getElementById(outImage).src = fr.result;
                };
                fr.readAsDataURL(files[0]);
            }
            // Not supported
            else {
                alert('Фотография выбрана');
            }
        }).on('click', '[data-link=form-submit]', function (e) {
            $('#userSettingsForm').yiiActiveForm('submitForm');
        }).on('click', '[data-link=change-password]', function (e) {
            showModal('changePasswordModal');
        });

        // Для страницы пользователя
        $('[data-link=to-recipes-block]').on('click', function (e) {
            Public.scrollTo($('#startRecipesBlock'));
        });

        // Страница списка статей
        $('#articlesCategory').on('click', '[data-link=search-articles]', function (e) {
            $('#search-articles-form').submit();
        });
    };

    function showModal(id) {
        $(".modalbox").hide();
        $("#" + id).fadeIn();
    }

    function init() {
        Listen();
    }

    return {
        init: init,
        public: Public
    };
})();

window.addEventListener("load", NaPlite.init);