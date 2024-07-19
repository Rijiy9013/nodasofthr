<?php

namespace NW\WebService\References\Operations\Notification;

class NotificationType
{
    const TYPE_NEW = 1;
    const TYPE_CHANGE = 2;

    public static function isValid(int $type): bool
    {
        $types = [
            self::TYPE_NEW,
            self::TYPE_CHANGE,
        ];

        return in_array($type, $types, true);
    }
}
