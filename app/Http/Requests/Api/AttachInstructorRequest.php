<?php
/**
 * File: AttachInstructorRequest.php
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
 * Class AttachInstructorRequest
 * @property-read string $person_id
 * @package App\Http\Requests\Api
 */
class AttachInstructorRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'description' => [
                'nullable',
                'string'
            ],
            'status' => [
                'required',
                'string',
                Rule::in(\App\Models\Instructor::STATUSES)
            ],
            'display' => [
                'nullable',
                'boolean'
            ],
            'person_id' => [
                'required',
                'string',
                'uuid',
                Rule::exists(Person::TABLE, 'id')
            ]
        ];
    }

    /**
     * @return DTO\Instructor
     */
    public function getDto(): DTO\Instructor
    {
        $validated = $this->validated();

        $dto = new DTO\Instructor;
        $dto->description = $validated['description'] ?? null;
        $dto->status = $validated['status'];
        $dto->display = (bool)($validated['display'] ?? null);

        return $dto;
    }
}
