<?php

namespace NW\WebService\References\Operations\Notification\Operations;

use NW\WebService\References\Operations\Notification\Exceptions\ValidationException;
use NW\WebService\References\Operations\Notification\NotificationEvents;
use NW\WebService\References\Operations\Notification\NotificationType;
use NW\WebService\References\Operations\Notification\Utils\RequestValidator;
use NW\WebService\References\Operations\Notification\Utils\TemplateDataCreator;
use function NW\WebService\References\Operations\Notification\Utils\getEmailsByPermit;
use function NW\WebService\References\Operations\Notification\Utils\getResellerEmailFrom;

class TsReturnOperation extends ReferencesOperation
{
    /**
     * @throws ValidationException
     */
    public function doOperation(): array
    {
        $data = $this->getRequest('data');
        RequestValidator::validate($data);

        $templateData = TemplateDataCreator::create($data);

        $result = $this->initializeResult();

        switch ((int)$data['notificationType']) {
            case NotificationType::TYPE_NEW:
                $this->handleNewType($data, $templateData, $result);
                break;
            case NotificationType::TYPE_CHANGE:
                $this->handleChangeType($data, $templateData, $result);
                break;
        }

        return $result;
    }

    private function handleNewType(array $data, array $templateData, array &$result): void
    {
        $templateData['differences'] = $data['differences']['from'];
        $this->notify(NotificationEvents::NEW_RETURN_STATUS, (int)$data['resellerId'], (int)$data['client']['id'], $templateData, $result, $data['client']['mobile']);
    }

    private function handleChangeType(array $data, array $templateData, array &$result): void
    {
        $templateData['differences'] = $data['differences']['to'];
        $this->notify(NotificationEvents::CHANGE_RETURN_STATUS, (int)$data['resellerId'], (int)$data['client']['id'], $templateData, $result, $data['client']['mobile']);
    }

    private function notify(string $event, int $resellerId, int $clientId, array $templateData, array &$result, ?string $clientMobile = null): void
    {
        $this->notifyByEmail($resellerId, $event, $templateData, $result);

        if (!empty($clientMobile)) {
            $this->notifyBySms($resellerId, $clientId, $event, $templateData['differences'], $templateData, $result);
        }
    }

    private function notifyByEmail(int $resellerId, string $event, array $templateData, array &$result): void
    {
        $emails = getEmailsByPermit($resellerId, $event);
        $from = getResellerEmailFrom();
        foreach ($emails as $email) {
            if ($this->sendEmail($email, $from, $templateData)) {
                $result['notificationEmployeeByEmail'] = true;
            }
        }
    }

    private function notifyBySms(int $resellerId, int $clientId, string $event, string $message, array $templateData, array &$result): void
    {
        $error = '';
        if ($this->sendSms($resellerId, $clientId, $event, $message, $templateData, $error)) {
            $result['notificationClientBySms']['isSent'] = true;
        }
        if (!empty($error)) {
            $result['notificationClientBySms']['message'] = $error;
        }
    }

    private function sendEmail(string $to, string $from, array $templateData): bool
    {
        // Mock implementation
        return NotificationManager::sendEmail($to, $from, $templateData);
    }

    private function sendSms(int $resellerId, int $clientId, string $event, string $message, array $templateData, string &$error): bool
    {
        // Mock implementation
        return NotificationManager::sendSms($resellerId, $clientId, $event, $message, $templateData, $error);
    }

    private function initializeResult(): array
    {
        return [
            'notificationEmployeeByEmail' => false,
            'notificationClientByEmail' => false,
            'notificationClientBySms' => [
                'isSent' => false,
                'message' => '',
            ],
        ];
    }
}
