<?php
/**
 * File: UpdateUserRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-20
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\Api
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => [
                'nullable',
                'string',
                'min:3',
                Rule::unique(\App\Models\User::TABLE)->ignore($this->route('user'))
            ],
            'name' => [
                'nullable',
                'string',
                'min:2',
            ],
        ];
    }

    /**
     * @return DTO\UserUpdate
     */
    public function getDto(): DTO\UserUpdate
    {
        $validated = $this->validated();

        $dto = new DTO\UserUpdate;
        $dto->name = $validated['name'];
        $dto->username = $validated['username'];

        return $dto;
    }
}
