<?php

namespace core\helpers;


use yii\helpers\HtmlPurifier;

class ContentHelper
{
    public static function output($content)
    {
        return HtmlPurifier::process($content, [
            'AutoFormat.Linkify' => true,
            //'AutoFormat.PurifierLinkify' => true
            'HTML.Allowed' => 'a[href],b,i,br,strong,ul,ol,li,s,u,p'
        ]);
    }
}