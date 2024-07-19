<?php

namespace NW\WebService\References\Operations\Notification\Utils;

use NW\WebService\References\Operations\Notification\Contractors\Contractor;
use NW\WebService\References\Operations\Notification\Contractors\Employee;
use NW\WebService\References\Operations\Notification\Contractors\Seller;
use NW\WebService\References\Operations\Notification\Exceptions\ValidationException;

class TemplateDataCreator
{
    public static function create(array $data): array
    {
        $reseller = self::getEntity(Seller::class, (int)$data['resellerId'], 'Seller not found!');
        $client = self::getEntity(Contractor::class, (int)$data['clientId'], 'Client not found!');
        RequestValidator::validateClient($client, (int)$data['resellerId']);
        $creator = self::getEntity(Employee::class, (int)$data['creatorId'], 'Creator not found!');
        $expert = self::getEntity(Employee::class, (int)$data['expertId'], 'Expert not found!');

        $cFullName = $client->getFullName() ?: $client->name;

        return [
            'date' => date('d.m.Y'),
            'seller' => $reseller->name,
            'client' => $cFullName,
            'contractor' => $expert->name,
            'creator' => $creator->getFullName()
        ];
    }

    private static function getEntity(string $class, int $id, string $errorMessage)
    {
        $entity = $class::getById($id);
        RequestValidator::validateEntity($entity, $errorMessage);
        return $entity;
    }
}
