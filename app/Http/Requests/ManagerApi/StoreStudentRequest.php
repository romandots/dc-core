<?php
/**
 * File: StoreStudentRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\ManagerApi;

use App\Models\Person;
use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreStudentRequest
 * @package App\Http\Requests\Api
 */
class StoreStudentRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'card_number' => [
                'nullable',
                'string',
                Rule::unique(Student::TABLE)
            ],
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
                'string',
                'date'
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
     * @return \App\Http\Requests\DTO\StorePerson
     */
    public function getPersonDto(): \App\Http\Requests\DTO\StorePerson
    {
        $validated = $this->validated();
        $dto = new \App\Http\Requests\DTO\StorePerson;
        $dto->last_name = $validated['last_name'] ?? null;
        $dto->first_name = $validated['first_name'] ?? null;
        $dto->patronymic_name = $validated['patronymic_name'] ?? null;
        $dto->birth_date = $validated['birth_date'] ? \Carbon\Carbon::parse($validated['birth_date']) : null;
        $dto->gender = $validated['gender'] ?? null;
        $dto->phone = $validated['phone'] ? \normalize_phone_number($validated['phone']) : null;
        $dto->email = $validated['email'] ?? null;
        $dto->instagram_username = $validated['instagram_username'] ?? null;
        $dto->telegram_username = $validated['telegram_username'] ?? null;
        $dto->vk_url = $validated['vk_url'] ?? null;
        $dto->facebook_url = $validated['facebook_url'] ?? null;
        $dto->note = $validated['note'] ?? null;
        $dto->picture = $this->file('picture');

        return $dto;
    }

    /**
     * @return \App\Http\Requests\DTO\StoreStudent
     */
    public function getStudentDto(): \App\Http\Requests\DTO\StoreStudent
    {
        $validated = $this->validated();
        $dto = new \App\Http\Requests\DTO\StoreStudent;
        $dto->card_number = $validated['card_number'];

        return $dto;
    }
}
