<?php
/**
 * File: UpdateStudentRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\ManagerApi;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateStudentRequest
 * @package App\Http\Requests\Api
 */
class UpdateStudentRequest extends FormRequest
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
                Rule::unique(Student::TABLE)->ignore($this->getStudentId())
            ],
        ];
    }

    /**
     * @return \App\Http\Requests\DTO\StoreStudent
     */
    public function getDto(): \App\Http\Requests\DTO\StoreStudent
    {
        $validated = $this->validated();
        $dto = new \App\Http\Requests\DTO\StoreStudent;
        $dto->card_number = $validated['card_number'] ?? null;

        return $dto;
    }

    /**
     * @return string
     */
    private function getStudentId(): string
    {
        return $this->route()->parameter('id');
    }
}
