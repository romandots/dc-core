<?php
/**
 * File: RegisterUser.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-12-5
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\DTO;

use App\Models\Instructor;
use App\Models\Student;

/**
 * Class RegisterUser
 * @package App\Http\Requests\DTO
 */
class RegisterUser
{
    public const TYPE_INSTRUCTOR = Instructor::class;
    public const TYPE_STUDENT = Student::class;

    public ?string $last_name;

    public ?string $first_name;

    public ?string $patronymic_name;

    public ?\Carbon\Carbon $birth_date;

    public ?string $gender;

    public string $phone;

    public ?string $email;

    /**
     * For instructors
     *
     * @var string|null
     */
    public ?string $description = null;

    public string $user_type;

    public ?string $password;

    public ?string $verification_code;
}