<?php

namespace core\helpers;


use core\entities\User\User;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

class ContentHelper
{
    public static function output($content)
    {
        return HtmlPurifier::process($content, [
            'AutoFormat.Linkify' => true,
            //'AutoFormat.PurifierLinkify' => true
            'HTML.Allowed' => 'a[href],b,i,br,strong,ul,ol,li,s,u,p,em,h1,h2,h3,h4,h5,h6,span,font,div,img[src]'
        ]);
    }

    public static function optimize($content)
    {
        return str_replace('<p>&nbsp;</p>', '', $content);
    }

    public static function breadcrumbsForUserPages($action, User $user)
    {
        switch ($action) {
            case 'recipes':
                $link = 'Рецепты автора';
                break;
            case 'cookbook':
                $link = 'Кулинарная книга';
                break;
            case 'posts':
                $link = 'Посты';
                break;
            case 'photos':
                $link = 'Фотоотчёты';
                break;
            default: $link = 'Рецепты';
        }
        return $action != 'view' ? '<span><i class="fa fa-circle"></i></span>'
                    //. '<a href=' . $user->pageUrl .'">' . $user->fullName . '</a>'
                    //. '<span><i class="fa fa-circle"></i></span>'
                    . '<a href="' . Url::to(['/users/' . $action, 'id' => $user->id]) . '">' . $link .'</a>'
            : '';
    }
}