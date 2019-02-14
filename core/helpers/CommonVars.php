<?php

namespace core\helpers;


class CommonVars
{
    public const IMPERAVI_SETTINGS = [
        'lang' => 'ru',
        'replaceDivs' => false,
        'minHeight' => 200,
        'buttons' => ['html','formatting','bold','italic','deleted',
            'unorderedlist','orderedlist','outdent','indent',
            'image','file','link','alignment','horizontalrule'],
        'plugins' => [
            'fontsize',
            'fontcolor',
            'clips',
            'fullscreen',
        ],
        /*'clips' => [
            ['Шаблон ингредиента', '<div class="my-class">Сам код шаблона ингредиента</div>'],
            ['Шаблон статьи', '<p class=my-class>Сам код шаблона статьи</p>'],
        ],*/
    ];
}