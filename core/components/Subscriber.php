<?php

namespace core\components;


class Subscriber
{
    public const SB_COMMENTS_NOTIFY = 'commentsNotify';
    public const SB_HOLIDAYS = 'holidays';

    public const DEFAULT_SUBSCRIBES = [
        self::SB_COMMENTS_NOTIFY => 1,
        self::SB_HOLIDAYS => 1,
    ];
}