var RecipeCreator = {} || RecipeCreator;
RecipeCreator = (function () {
    var $recipeForm = $('#recipeForm'),
        $mainPhotoInput = $('#main-photo-num'),
        $holidayInput = $('#holiday-input');

    var Listen = function () {

        // Загрузка файлов
        $recipeForm.on('click', '.upload-link', function (e) {
            $(this).find("input[type=file]").click();
        }).on('click', '.upload-file', function (e) {
            e.stopPropagation();
        }).on("change", '.upload-file', function (e) {
            var $boxLoader = NaPlite.public.getBoxLoader(),
                $link = $(e.target).parent(),
                isSmallBox = $link.parent().hasClass('uploadbox_small');

            $link.before($boxLoader);
            setBigUploadBoxEmpty($link.parent());

            var files = $(e.target)[0].files;
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', uploadProgress, false);
            xhr.onreadystatechange = stateChange;
            xhr.open('POST', '/recipes/upload');
            var formData = new FormData();
            $.each(files, function(k, file) {
                formData.append("file[]", file);
            });
            formData.append("_csrf-frontend", yii.getCsrfToken());
            formData.append("num", $link.find('input[type=hidden]').attr('data-num'));
            formData.append("type", isSmallBox ? 'step' : 'recipe');
            xhr.send(formData);

            function uploadProgress(event) {
                var percent = parseInt(event.loaded / event.total * 100);
                $boxLoader.find(".box-uploader-progress").css('width', percent + '%');
            }

            function stateChange(event) {
                if (event.target.readyState === 4) {
                    if (event.target.status === 200) {
                        var data = jQuery.parseJSON(event.target.responseText);
                        if (data.result === 'error') {
                            $link.find('span').html(data.message);
                        } else {
                            $.each(data.files, function (num, names) {
                                var $appendTo;
                                if (isSmallBox) {
                                    $appendTo = $link;
                                } else if ($link.find('input[data-num=' + num + ']').length) {
                                    $appendTo = $link;
                                } else {
                                    var $newBox = appendBigUploadBox();
                                    $appendTo = $newBox.find('.upload-link');
                                }
                                $appendTo.find('img').remove();
                                $appendTo.find('i, span').hide();
                                if (!isSmallBox) {
                                    $appendTo.parent().prepend('<a href="javascript:void(0)" class="ico-close" title="Удалить фотографию"><i class="fa fa-close"></i></a>');
                                    $appendTo.parent().prepend('<a href="javascript:void(0)" class="ico-main" title="Сделать главной"><i class="fa fa-check-circle-o"></i></a>');
                                }
                                $appendTo.prepend('<img src="/tmp/' + names.name + '">');
                                $appendTo.find('input[type=hidden]').val(names.name);

                                if (!isSmallBox && !checkMainPhoto()) {
                                    $appendTo.parent().find('.ico-main').addClass('active');
                                    $mainPhotoInput.val($appendTo.find('input[type=hidden]').attr('data-num'));
                                }
                            });
                        }
                    } else {
                        console.log("error");
                    }
                    $boxLoader.remove();
                }
            }
        });

        // Удаление фото
        $recipeForm.on('click', '.ico-close', function (e) {
            e.stopPropagation();
            if ($recipeForm.find('.uploadbox_big').length < 2) {
                setBigUploadBoxEmpty($(this).parent());
            } else {
                $(this).parent().remove();
            }
            if (!checkMainPhoto()) {
                var $firstBox = $recipeForm.find('.uploadbox_big').first();
                $firstBox.find('.ico-main').first().addClass('active');
                $mainPhotoInput.val($firstBox.find('input[type=hidden]').attr('data-num'));
            }
        });

        // Отмечание главного фото
        $recipeForm.on('click', '.ico-main', function (e) {
            e.stopPropagation();
            $recipeForm.find('.ico-main').removeClass('active');
            var $box = $(this).parent();
            $mainPhotoInput.val($box.find('input[type=hidden]').attr('data-num'));
            $(this).addClass('active');
        });

        // Стрелочки вверх/вниз над временем приготовления и готовки
        $recipeForm.on('click', '.time-control', function (e) {
            var $input = $(this).parent().find('input');
            var direction = $(this).attr('data-direction');
            var type = $(this).attr('data-type');
            var value = Number($input.val());
            value = !value ? 0 : value;
            value = direction === 'up' ? value + 1 : value - 1;
            value = value < 0 ? 0 : value;
            if (type === 'minutes') {
                if (value > 59) {
                    value = '00';
                    var $hoursInput = $input.parent().parent().find('.hours-block').find('input');
                    var hours = Number($hoursInput.val());
                    hours = !hours ? 0 : hours;
                    hours = hours < 0 ? 0 : hours;
                    hours++;
                    $hoursInput.val(hours);
                } else if (value < 10) {
                    value = '0' + value;
                }
            }
            $input.val(value);
        });

        // Выбор праздников
        $holidayInput.on('click', function (e) {
            $(".modalbox").hide();
            $("#holidaysModal").fadeIn();
        });
        $('#holidaysModal').on('change', 'input[name*=holidays]', function (e) {
            var count = $('#holidaysModal').find('input[type=checkbox]:checked').length;
            $holidayInput.val(NaPlite.public.pluralize(count, ['Выбран', 'Выбрано', 'Выбрано']) + ' ' + count + ' ' + NaPlite.public.pluralize(count, ['праздник', 'праздника', 'праздников']));
        });

        $recipeForm.on('click', 'input[name*=ingredientUom]', function (e) {
            $(this).autocomplete( "search", "" );
        });

        // Удаление секций и ингредиентов
        $recipeForm.on('click', '[data-button=removeIngredient]', function (e) {
            var $section = $(this).parent().parent().parent();
            if ($section.find('.add_ing_inputs').length > 1) {
                $(this).parent().parent().remove();
            }
        });
        $recipeForm.on('click', '[data-button=removeSection]', function (e) {
            if ($recipeForm.find('.add_ing_box').length > 1) {
                $(this).parent().remove();
            }
        });

        // Добавление ингредиента
        $recipeForm.on('change', 'input[name*=ingredientName],input[name*=ingredientQuantity]', function (e) {
            var $section = $(this).parent().parent().parent().parent();
            var hasEmpty = false;
            $.each($section.find('input[name*=ingredientName],input[name*=ingredientQuantity]'), function (k, input) {
                if (!$(input).val()) {
                    hasEmpty = true;
                }
            });
            if (!hasEmpty) {
                var sectionNum = Number($section.attr('data-num'));
                addIngredientRow(sectionNum);
            }
        });

        // Добавление секции инредиентов
        $recipeForm.on('click', '[data-button=addIngredientSection]', function (e) {
            var $lastSection = $('.add_ing_box').last(),
                $section = $lastSection.clone(),
                $sectionNameInput = $section.find('input[name*=ingredientSection]'),
                sectionNum = Number($lastSection.attr('data-num')) + 1;

            $section.attr('data-num', sectionNum);
            $section.find('.add_ing_inputs').remove();
            $sectionNameInput.attr('id', 'recipeform-ingredientsection-' + sectionNum)
                .attr('name', 'RecipeForm[ingredientSection][' + sectionNum + ']')
                .val('');

            $lastSection.after($section);
            addIngredientRow(sectionNum);
            addIngredientRow(sectionNum);
            addIngredientRow(sectionNum);
            addIngredientRow(sectionNum);

            $('html, body').animate({
                scrollTop: $section.offset().top
            }, 800);
        });

        // Добавление шага
        $recipeForm.on('click', '[data-button=addStep]', function (e) {
            var $lastStep = $recipeForm.find('.add_steps_box').last(),
                stepNumber = Number($lastStep.attr('data-num')) + 1,
                $stepBox = $lastStep.clone();

            // wysiwyg remove
            $stepBox.find('textarea').removeAttr('style');
            $stepBox.find('.inputbox_input > div[id^=cke_]').remove();

            $stepBox.attr('data-num', stepNumber);
            $stepBox.find('.inputbox_label_left').first().html('Шаг ' + stepNumber + ':');
            $stepBox.find('textarea')
                .attr('id', 'recipeform-stepdescription-' + stepNumber)
                .attr('name', 'RecipeForm[stepDescription][' + stepNumber + ']')
                .val('');
            $stepBox.find('.uploadbox_small').find('input[type=hidden]')
                .attr('id', 'recipeform-stepphoto-' + stepNumber)
                .attr('name', 'RecipeForm[stepPhoto][' + stepNumber + ']');
            setBigUploadBoxEmpty($stepBox.find('.uploadbox_small'));
            $lastStep.after($stepBox);

            // wysiwyg init
            NaPlite.public.SetCKEditor('recipeform-stepdescription-' + stepNumber);

            $('html, body').animate({
                scrollTop: $stepBox.offset().top
            }, 800);
        });

        // Submit формы
        $recipeForm.on('click', '[data-button=submitForm]', function (e) {
            // Переводим с wysiwyg в textarea's
            var introductoryText = CKEDITOR.instances['introductoryTextArea'].ui.editor.getData();
            $('#introductoryTextArea').val(introductoryText);
            var notes = CKEDITOR.instances['notesArea'].ui.editor.getData();
            $('#notesArea').val(notes);
            $.each($('textarea[name*=stepDescription]'), function (k, area) {
                $(area).val(CKEDITOR.instances[$(area).attr('id')].ui.editor.getData());
            });

            // Проверка фото рецепта
            if (!$recipeForm.find('input[name*=photos]').filter(function() {
                    return this.value.length !== 0;
                }).length) {
                NaPlite.public.messageModal('Нет фото!', 'Загрузите пожалуйста хотя бы одну фотографию рецепта');
                $('html, body').animate({
                    scrollTop: $('.uploadbox_big').offset().top
                }, 800);
                return;
            }
            // Ингредиенты
            var $ingredientRows = $recipeForm.find('.add_ing_inputs');
            var notEmpty = false;
            $.each($ingredientRows, function (k, row) {
                var $row = $(row);
                if ($row.find('input[name*=ingredientName]').val().length > 0 && $row.find('input[name*=ingredientQuantity]').val().length > 0) {
                    notEmpty = true;
                }
            });
            if (!notEmpty) {
                NaPlite.public.messageModal('Ингредиенты', 'Вы не указали ни одного ингредиента<br>Укажите название и количество');
                $('html, body').animate({
                    scrollTop: $('.add_ing_box').offset().top
                }, 800);
                return;
            }
            // Шаги приготовления
            if (!$recipeForm.find('textarea[name*=stepDescription]').filter(function() {
                    return this.value.length !== 0;
                }).length) {
                NaPlite.public.messageModal('Способ<br>приготовления', 'Опишите пожалуйста способ приготовления<br>по шагам');
                $('html, body').animate({
                    scrollTop: $('.add_steps').offset().top
                }, 800);
                return;
            }

            $('#commentsNotify').val($("#commentsNotifyVisibleInput").is(':checked') ? 1 : 0);

            $recipeForm.yiiActiveForm('submitForm');
        });

        $(".hours-block,.minutes-block,.time-colon").on('mouseenter',function(){
            var $el = $(this).hasClass('time-colon') ? $(this).parent().find('.time-control') : $(this).find('.time-control');
            $el.addClass('active');
        }).on('mouseleave',function(){
            var $el = $(this).hasClass('time-colon') ? $(this).parent().find('.time-control') : $(this).find('.time-control');
            $el.removeClass('active');
        });

        $('.arrows-input').on('mouseenter',function(){
            $(this).find('.arrow').addClass('active');
        }).on('mouseleave',function(){
            $(this).find('.arrow').removeClass('active');
        }).on('click', '.arrow', function () {
            var $select = $('select[name*=persons]'),
                current = Number($select.val()),
                value = $(this).attr('data-direction') === 'up' ? current + 1 : current - 1;
            if (value < 1) {
                value = 1;
            } else if (value > 10) {
                value = 10;
            }
            $select.val(value);
        });
    };
    
    function initWysiwyg() {
        NaPlite.public.SetCKEditor('introductoryTextArea');
        NaPlite.public.SetCKEditor('notesArea');
        $.each($('textarea[name*=stepDescription]'), function (k, area) {
            NaPlite.public.SetCKEditor($(area).attr('id'));
        });
    }

    function addIngredientRow(sectionNum) {
        var $lastIngredientRow = $recipeForm.find('.add_ing_inputs').last();
        var $ingredientRow = $lastIngredientRow.clone();
        var $nameInput = $ingredientRow.find('input[name*=ingredientName]');
        var $quantityInput = $ingredientRow.find('input[name*=ingredientQuantity]');
        var $uomInput = $ingredientRow.find('input[name*=ingredientUom]');
        var $section = $recipeForm.find('.add_ing_box[data-num=' + sectionNum + ']');
        var ingredientNum;

        if (!$section.find('.add_ing_inputs').length) {
            ingredientNum = 0;
        } else {
            ingredientNum = Number($section.find('input[name*=ingredientName]').last().attr('data-num')) + 1;
        }

        $nameInput.attr('id', 'ing-'+sectionNum+'-'+ingredientNum)
            .attr('name', 'RecipeForm[ingredientName]['+sectionNum+']['+ingredientNum+']')
            .val('')
            .autocomplete({
                source: function(request, response) {
                    $.getJSON('/ingredients/auto-complete', {
                        value: request.term
                    }, response);
                },
                minLength: 3
            });
        $quantityInput.attr('id', 'recipeform-ingredientquantity-'+sectionNum+'-'+ingredientNum)
            .attr('name', 'RecipeForm[ingredientQuantity]['+sectionNum+']['+ingredientNum+']')
            .val('');
        $uomInput.attr('id', 'uom-'+sectionNum+'-'+ingredientNum)
            .attr('name', 'RecipeForm[ingredientUom]['+sectionNum+']['+ingredientNum+']')
            .val('')
            .autocomplete({
                source: ingredientsUom,
                minLength: 0
            });

        if (!$section.find('.add_ing_inputs').length) {
            $section.find('.add_ing_descr').last().after($ingredientRow);
        } else {
            $section.find('.add_ing_inputs').last().after($ingredientRow);
        }
    }

    function checkMainPhoto() {
        return $recipeForm.find('.ico-main.active').length;
    }

    function appendBigUploadBox() {
        var $lastBox = $('.uploadbox_big').last();
        var $newBox = $lastBox.clone();
        var lastNum = Number($lastBox.find('input[type=hidden]').attr('data-num'));
        var oldName = $newBox.find('input[type=hidden]').attr('name');
        $newBox.find('.box-uploader').remove();
        setBigUploadBoxEmpty($newBox);
        $newBox.find('input[type=hidden]').attr('data-num', lastNum + 1).attr('name', oldName.replace(lastNum, lastNum + 1));
        $lastBox.after($newBox);
        return $newBox;
    }

    function setBigUploadBoxEmpty($box) {
        $box.find('img').remove();
        $box.find('span').html($box.find(".default-text").html());
        $box.find('.ico-close').remove();
        $box.find('.ico-main').remove();
        $box.find('i, span').show();
        $box.find('input[type=hidden]').val('');
    }

    function init() {
        Listen();
        initWysiwyg();

        $('#holiday-input').select2MultiCheckboxes({
            templateSelection: function(selected, total) {
                if (!selected.length) {
                    return 'Укажите праздники';
                }
                return NaPlite.public.pluralize(selected.length, ['Выбран', 'Выбрано', 'Выбрано']) + ' ' + selected.length + ' ' + NaPlite.public.pluralize(selected.length, ['праздник', 'праздника', 'праздников']);
            },
            placeholder: "Укажите праздники",
            dropdownCssClass: 'select_base'
        });
    }

    return {
        init: init
    };
})();

window.addEventListener("load", RecipeCreator.init);