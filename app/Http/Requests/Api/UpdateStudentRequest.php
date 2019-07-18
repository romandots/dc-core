<?php
/**
 * File: UpdateStudentRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api;

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
                'number',
                Rule::unique(Student::TABLE)
            ],
        ];
    }

    /**
     * @return DTO\UpdateStudent
     */
    public function getDto(): DTO\UpdateStudent
    {
        $validated = $this->validated();
        $dto = new DTO\UpdateStudent;
        $dto->card_number = $validated['card_number'];

        return $dto;
    }
}
