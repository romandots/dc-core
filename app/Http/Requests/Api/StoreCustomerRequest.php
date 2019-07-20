<?php
/**
 * File: StoreCustomerRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-19
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreCustomerRequest
 * @package App\Http\Requests\Api
 */
class StoreCustomerRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'last_name' => [
                'required',
                'string'
            ],
            'first_name' => [
                'required',
                'string'
            ],
            'patronymic_name' => [
                'required',
                'string'
            ],
            'birth_date' => [
                'required',
                'string',
                'date'
            ],
            'gender' => [
                'nullable',
                'string',
                Rule::in(Person::GENDER)
            ],
            'phone' => [
                'required',
                'string'
            ],
            'email' => [
                'nullable',
                'string',
                'email'
            ],
            'instagram_username' => [
                'nullable',
                'string'
            ],
            'telegram_username' => [
                'nullable',
                'string'
            ],
            'vk_url' => [
                'nullable',
                'string',
                'url'
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
     * @return DTO\Person
     */
    public function getPersonDto(): DTO\Person
    {
        $validated = $this->validated();

        $dto = new DTO\Person;
        $dto->last_name = $validated['last_name'] ?? $validated['last_name'];
        $dto->first_name = $validated['first_name'] ?? $validated['first_name'];
        $dto->patronymic_name = $validated['patronymic_name'] ?? $validated['patronymic_name'];
        $dto->birth_date = $validated['birth_date'] ? \Carbon\Carbon::parse($validated['birth_date']) : null;
        $dto->gender = $validated['gender'] ?? null;
        $dto->phone = $validated['phone'] ? \phone_format($validated['phone']) : null;
        $dto->email = $validated['email'] ?? $validated['email'];
        $dto->instagram_username = $validated['instagram_username'] ?? $validated['instagram_username'];
        $dto->telegram_username = $validated['telegram_username'] ?? $validated['telegram_username'];
        $dto->vk_url = $validated['vk_url'] ?? $validated['vk_url'];
        $dto->facebook_url = $validated['facebook_url'] ?? $validated['facebook_url'];
        $dto->note = $validated['note'] ?? $validated['note'];

        return $dto;
    }

    /**
     * @return DTO\Customer
     */
    public function getCustomerDto(): DTO\Customer
    {
        $validated = $this->validated();

        $dto = new DTO\Customer;
        $dto->person_id = $validated['person_id'];

        return $dto;
    }
}
