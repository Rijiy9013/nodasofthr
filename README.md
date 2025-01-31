### 1. Созданы отдельные классы для валидации и создания данных шаблона

- **RequestValidator.php**:
    - Содержит методы для валидации входящих данных запросов.
    - Убеждается, что все необходимые поля присутствуют и имеют правильный тип.
    - Валидирует конкретные сущности, такие как `Client` и `NotificationType`.

- **TemplateDataCreator.php**:
    - Создает данные шаблона, используемые в email и SMS уведомлениях.
    - Выносит логику получения и валидации сущностей, улучшая разделение ответственности.

### 2. Улучшена структура проекта

- Добавлена директория `Enums` для констант и перечислений.
- Связанные файлы сгруппированы в соответствующие директории (`Contractors`, `Enums`, `Exceptions`, `Operations`, `Utils`).

### 3. Расширена логика валидации

- **Validator.php**:
    - Предоставляет универсальный метод для валидации массивов согласно набору правил.
 
- **RequestValidator.php**:
    - Использует `Validator` для валидации данных запросов.
    - Включает дополнительную логику для валидации сущностей и типов уведомлений.

### 4. Обновлен TsReturnOperation

- Рефакторинг `TsReturnOperation.php` для использования новых классов `RequestValidator` и `TemplateDataCreator`.
- Улучшена структура методов для обработки различных типов уведомлений.
- Добавлены приватные методы для уведомлений по email и SMS.