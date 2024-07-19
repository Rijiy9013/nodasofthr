<?php

namespace NW\WebService\References\Operations\Notification\Contractors;

class Contractor
{
    const TYPE_CUSTOMER = 0;
    public $id;
    public $type;
    public $name;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function getById(int $resellerId): ?self
    {
        // Заглушка
        return new self($resellerId);
    }

    public function getFullName(): string
    {
        // Заглушка
        return $this->name . ' ' . $this->id;
    }
}
