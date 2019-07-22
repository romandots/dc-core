<?php
/**
 * File: ProfilesPermissions.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-22
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Services\Permissions;

/**
 * Class ProfilesPermissions
 * @package App\Services\Permissions
 */
class ProfilesPermissions
{
    public const MANAGE_PROFILES = 'manage_profiles';
    public const CREATE_PROFILES = 'create_profiles';
    public const READ_PROFILES = 'read_profiles';
    public const UPDATE_PROFILES = 'update_profiles';
    public const DELETE_PROFILES = 'delete_profiles';

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
            self::MANAGE_PROFILES => 'Управлять инструкторами',
            self::CREATE_PROFILES => 'Создавать инструкторов',
            self::READ_PROFILES => 'Просматривать инструкторов',
            self::UPDATE_PROFILES => 'Обновлять инструкторов',
            self::DELETE_PROFILES => 'Удалять инструкторов',
        ];
    }
}
