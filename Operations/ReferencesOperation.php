<?php

namespace NW\WebService\References\Operations\Notification\Operations;

abstract class ReferencesOperation
{
    abstract public function doOperation(): array;

    public function getRequest(string $pName): ?array
    {
        return filter_input(INPUT_REQUEST, $pName, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    }
}
