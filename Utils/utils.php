<?php

namespace NW\WebService\References\Operations\Notification\Utils;

/**
 * Получить список email адресов по разрешению
 *
 * @param int $resellerId Идентификатор реселлера
 * @param string $event Событие уведомления
 * @return array Список email адресов
 */
function getEmailsByPermit(int $resellerId, string $event): array
{
    // Реализация функции, возвращающей список email адресов
    return ['someemail@example.com', 'someemail2@example.com'];
}

/**
 * Получить email отправителя для реселлера
 *
 * @return string Email адрес отправителя
 */
function getResellerEmailFrom(): string
{
    // Реализация функции, возвращающей email отправителя
    return 'contractor@example.com';
}
