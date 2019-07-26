<?php
/**
 * File: PersonsPermissions.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-22
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Services\Permissions;

/**
 * Class PersonsPermissions
 * @package App\Services\Permissions
 */
class PersonsPermissions
{
    public const MANAGE_PERSONS = 'manage_persons';
    public const CREATE_PERSONS = 'create_persons';
    public const READ_PERSONS = 'read_persons';
    public const UPDATE_PERSONS = 'update_persons';
    public const DELETE_PERSONS = 'delete_persons';

    /**
     * Get names of all defined permissions
     *
     * @return string[]
     * @throws \ReflectionException
     */
    public static function getAllNames(): array
    {
        $reflection = new \ReflectionClass(__CLASS__);

        return \array_values($reflection->getConstants());
    }

    /**
     * Get all built-in permission descriptions
     *
     * @return string[]
     */
    public static function getInitialDescriptions(): array
    {
        return [
            self::MANAGE_PERSONS => 'Управлять инструкторами',
            self::CREATE_PERSONS => 'Создавать инструкторов',
            self::READ_PERSONS => 'Просматривать инструкторов',
            self::UPDATE_PERSONS => 'Обновлять инструкторов',
            self::DELETE_PERSONS => 'Удалять инструкторов',
        ];
    }
}
