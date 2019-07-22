<?php
/**
 * File: UserUpdate.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-21
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api\DTO;

/**
 * Class UserUpdate
 * @package App\Http\Requests\Api\DTO
 */
class UserUpdate
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $username;
}
