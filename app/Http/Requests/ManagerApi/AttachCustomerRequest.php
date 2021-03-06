<?php
/**
 * File: AttachCustomerRequest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-19
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\ManagerApi;

use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class AttachCustomerRequest
 * @property-read int $person_id
 * @package App\Http\Requests\Api
 */
class AttachCustomerRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'person_id' => [
                'required',
                'string',
                'uuid',
                Rule::exists(Person::TABLE, 'id')
            ]
        ];
    }

    /**
     * @return DTO\StoreCustomer
     */
    public function getDto(): DTO\StoreCustomer
    {
        $validated = $this->validated();

        $dto = new DTO\StoreCustomer;
        $dto->person_id = $validated['person_id'];

        return $dto;
    }
}
