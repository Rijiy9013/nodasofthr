<?php

namespace NW\WebService\References\Operations\Notification\Utils;

use NW\WebService\References\Operations\Notification\Exceptions\ValidationException;

class Validator
{
    public static function validate(array $data, array $rules): void
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $singleRule) {
                switch ($singleRule) {
                    case 'required':
                        if (!isset($data[$field]) || empty($data[$field])) {
                            throw new ValidationException("The field {$field} is required.");
                        }
                        break;
                    case 'integer':
                        if (!is_int($data[$field])) {
                            throw new ValidationException("The field {$field} must be an integer.");
                        }
                        break;
                    case 'array':
                        if (!is_array($data[$field])) {
                            throw new ValidationException("The field {$field} must be an array.");
                        }
                        break;
                }
            }
        }
    }
}
