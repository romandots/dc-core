<?php
/**
 * File: StorePersonRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StorePersonRequest
 * @package App\Http\Requests
 */
class StorePersonRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'last_name' => [
                'nullable',
                'string'
            ],
            'first_name' => [
                'required',
                'string'
            ],
            'patronymic_name' => [
                'nullable',
                'string'
            ],
            'birth_date' => [
                'nullable',
                'string'
            ],
            'gender' => [
                'nullable',
                'string',
                Rule::in(Person::GENDER)
            ],
            'phone' => [
                'nullable',
                'string'
            ],
            'email' => [
                'nullable',
                'string',
                'email'
            ],
            'picture' => [
                'nullable',
                'string',
                'url'
            ],
            'picture_thumb' => [
                'nullable',
                'string',
                'url'
            ],
            'instagram_username' => [
                'nullable',
                'string'
            ],
            'telegram_username' => [
                'nullable',
                'string'
            ],
            'vk_uid' => [
                'nullable',
                'string'
            ],
            'vk_url' => [
                'nullable',
                'string',
                'url'
            ],
            'facebook_uid' => [
                'nullable',
                'string'
            ],
            'facebook_url' => [
                'nullable',
                'string',
                'url'
            ],
            'note' => [
                'nullable',
                'string'
            ],
        ];
    }

    /**
     * @return DTO\StorePerson
     */
    public function getDto(): DTO\StorePerson
    {
        $validated = $this->validated();
        $dto = new \App\Http\Requests\Api\DTO\StorePerson;
        $dto->last_name = $validated['last_name'];
        $dto->first_name = $validated['first_name'];
        $dto->patronymic_name = $validated['patronymic_name'];
        $dto->birth_date = $validated['birth_date'] ?? \Carbon\Carbon::parse($validated['birth_date']);
        $dto->gender = $validated['gender'];
        $dto->phone = isset($validated['phone']) ? \phone_format($validated['phone']) : null;
        $dto->email = $validated['email'];
        $dto->picture = $validated['picture'];
        $dto->picture_thumb = $validated['picture_thumb'];
        $dto->instagram_username = $validated['instagram_username'];
        $dto->telegram_username = $validated['telegram_username'];
        $dto->vk_uid = $validated['vk_uid'];
        $dto->vk_url = $validated['vk_url'];
        $dto->facebook_uid = $validated['facebook_uid'];
        $dto->facebook_url = $validated['facebook_url'];
        $dto->note = $validated['note'];

        return $dto;
    }
}
