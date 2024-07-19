<?php

namespace NW\WebService\References\Operations\Notification\Utils;

use NW\WebService\References\Operations\Notification\Contractors\Contractor;
use NW\WebService\References\Operations\Notification\Exceptions\ValidationException;
use NW\WebService\References\Operations\Notification\NotificationType;

class RequestValidator
{
    public static function validate(array $data): void
    {
        $rules = [
            'resellerId' => 'required|integer',
            'notificationType' => 'required|integer',
            'clientId' => 'required|integer',
            'creatorId' => 'required|integer',
            'expertId' => 'required|integer',
            'differences' => 'required|array'
        ];

        Validator::validate($data, $rules);

        if (!NotificationType::isValid((int)$data['notificationType'])) {
            throw new ValidationException('Invalid notification type', 400);
        }
    }

    public static function validateClient(Contractor $client, int $resellerId): void
    {
        if ($client->type !== Contractor::TYPE_CUSTOMER || $client->Seller->id !== $resellerId) {
            throw new ValidationException('Client not found!', 400);
        }
    }

    public static function validateEntity($entity, string $errorMessage): void
    {
        if ($entity === null) {
            throw new ValidationException($errorMessage, 400);
        }
    }
}
