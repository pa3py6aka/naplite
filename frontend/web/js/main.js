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
        getSpinLoader: function () {
            return '<div class="overlay"><img src="/img/spin.gif" class="fa fa-spin"></div>';
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
            setTimeout('$(".modalbox").fadeOut()', 4000);
        },
        scrollTo: function ($el) {
            $('html, body').animate({
                scrollTop: $el.offset().top
            }, 800);
        },
        SetCKEditor: function (id) {
            CKEDITOR.replace(id, {
                "height":120,
                "contentsCss": "/css/wysiwyg.css",
                "bodyClass": "wysiwyg-style",
                "toolbarGroups":[
                    //{"name":"undo"},
                    {"name":"basicstyles","groups":["basicstyles"]},
                    {"name": "paragraph","groups":["list"]},
                    //{"name":"colors"},
                    {"name":"links","groups":["insert"]}
                    //{"name":"others","groups":["others","about"]}
                ],
                "removeButtons":"Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Link,Unlink,Anchor",
                "removePlugins":"elementspath",
                "resize_enabled":false,
                "extraPlugins": "emojione"
            });
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

        $(document).on('click', '[data-type="submit-form-link"]', function () {
            showPreloader($(this));
            $('#' + $(this).attr('data-form-id')).submit();
        });

        var isSubmit = false;
        $(document).on('beforeSubmit', '[data-type=form]', function (e) {
            isSubmit = true;
            //showPreloader($(this));
            return true;
        }).on('ajaxBeforeSend', '[data-type=form]', function (e) {
            //alert(2);
            //showPreloader($(this));
            return true;
        }).on('ajaxComplete', '[data-type=form]', function (e) {
            //alert(3);
            if (!isSubmit) {
                $(this).find('.overlay').remove();
            }
        }).on('afterValidate', '[data-type=form]', function (e) {
            if (!isSubmit) {
                if ($(this).attr('id') === 'userSettingsForm') {
                    $('[data-form-id="userSettingsForm"]').find('.overlay').remove();
                }/* else {
                    $(this).find('.overlay').remove();
                }*/
            }
        });

        $('[data-link=goToSearch]').on('click', function () {
            var $form = $('#mainSearchBlock');
            Public.scrollTo($form);
            $form.find('input[name=q]').focus();
        });

        $('[data-link="main-search-link"]').on('click', function () {
            var $form = $(this).attr('data-type') === 'main' ? $('#mainSearchForm') : $('#mainSearchFormAdaptive');
            $form.submit();
        });

        $('[data-link=readSeoText]').on('click', function () {
            var $link = $(this);
            var $textBlock = $link.parent().find('.th_parent_seo');
            if ($textBlock.hasClass('mini')) {
                $textBlock.removeClass('mini');
                $link.html('<i class="fa fa-refresh"></i>Скрыть');
            } else {
                $textBlock.addClass('mini');
                $link.html('<i class="fa fa-refresh"></i>Читать далее');
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

        // Создание поста
        var $blogForm = $('#blogForm');
        $blogForm.on('click', '[data-button=submitForm]', function (e) {
            var contentText = CKEDITOR.instances['new-post-content-area'].ui.editor.getData();
            $('#new-post-content-area').val(contentText);
            $blogForm.yiiActiveForm('submitForm');
        });
        if ($blogForm.length) {
            Public.SetCKEditor('new-post-content-area');
        }

        // Поиск по форуму
        $('#blogsListPage').on('click', '[data-button=submit-blog-search]', function (e) {
            $('#searchBlogsForm').submit();
        });

        // Таблица мер и весов
        $('[data-link=weights-search-modal]').on('click', function (e) {
            showModal('weightsModal');
            //$('#weightsSearchForm').find('input[name=search]').val('');
            loadWeights();
        });
        $('[data-link=weights-search-link]').on('click', function () {
            loadWeights();
        });
        $('#weightsSearchForm').submit(function(e) {
            e.preventDefault();
            loadWeights();
        });

        // Страница списка ингредиентов
        $('#ingredientsCategory').on('click', '[data-link=search-ingredients]', function (e) {
            $('#search-ingredients-form').submit();
        });

        // Social block widget
        $(".socials_plugin").on('click', '.socials_tabs > a', function (e) {
            var $block = $(".socials_plugin"),
                sn = $(this).attr('data-sn');
            $block.find('.socials_tabs > a').removeClass('socials_tabs_active');
            $(this).addClass('socials_tabs_active');
            $block.find('.socials_content').hide();
            $block.find('.socials_content[data-sn=' + sn + ']').show();
        });

        $('.main-search-input').data("ui-autocomplete")._renderItem = function (ul, item) {
            var html = item.label;
            //item.label = $(html).find('h4').find('a').text();
            item.value = $(html).find('h4').find('a').text();
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append(html)
                .appendTo(ul);
        };
        $(".main-search-input").on("autocompleteselect", function( event, ui ) {
            var url = $(ui.item.label).find('h4').find('a').attr('href');
            document.location.href = url;
        });
    };

    function showPreloader($el) {
        if (!$el.find('.overlay').length) {
            $el.prepend(Public.getSpinLoader());
        }
    }

    function loadWeights() {
        var $modal = $('#weightsModal'),
            $contentBlock = $modal.find('#weightsSearchContent'),
            $form = $('#weightsSearchForm');

        $.ajax({
            url: '/weights/load',
            method: "post",
            dataType: "html",
            data: $form.serialize(),
            beforeSend: function () {
                if (!$contentBlock.find('.overlay').length) {
                    $contentBlock.prepend(Public.getSpinLoader());
                }
            },
            success: function(data, textStatus, jqXHR) {
                $contentBlock.html(data);
            },
            complete: function () {
                $contentBlock.find('.overlay').remove();
            }
        });
        if (!$contentBlock.find('.overlay').length) {
            $contentBlock.prepend(Public.getSpinLoader());
        }
    }

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