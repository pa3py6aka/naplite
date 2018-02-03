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
            'HTML.Allowed' => 'a[href],b,i,br,strong,ul,ol,li,s,u,p,em,h1,h2,h3,h4,h5,h6,span,font,div,img'
        ]);
    }

    public static function optimize($content)
    {
        return str_replace('<p>&nbsp;</p>', '', $content);
    }
}