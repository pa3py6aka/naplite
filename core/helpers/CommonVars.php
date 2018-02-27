<?php

namespace core\helpers;


class CommonVars
{
    public const IMPERAVI_SETTINGS = [
        'lang' => 'ru',
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
    ];
}