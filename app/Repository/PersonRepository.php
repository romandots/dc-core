<?php
/**
 * File: PersonRepository.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Repository;

use App\Http\Requests\Api\DTO\Person as PersonDto;
use App\Models\Person;
use Carbon\Carbon;

/**
 * Class PersonRepository
 * @package App\Repository
 */
class PersonRepository
{
    /**
     * @param int $id
     * @return Person|null
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find(int $id): ?Person
    {
        return Person::query()->findOrFail($id);
    }

    /**
     * @param PersonDto $dto
     * @return Person
     */
    public function create(PersonDto $dto): Person
    {
        $person = new Person;
        $this->fill($person, $dto);
        $person->save();

        return $person;
    }

    /**
     * @param Person $person
     * @param PersonDto $dto
     * @return Person
     */
    public function update(Person $person, PersonDto $dto): Person
    {
        $this->fill($person, $dto);
        $person->save();

        return $person;
    }

    /**
     * @param Person $person
     * @param PersonDto $dto
     */
    private function fill(Person $person, PersonDto $dto): void
    {
        $person->last_name = $dto->last_name;
        $person->first_name = $dto->first_name;
        $person->patronymic_name = $dto->patronymic_name;
        $person->birth_date = $dto->birth_date;
        $person->gender = $dto->gender;
        $person->phone = $dto->phone;
        $person->email = $dto->email;
        $person->instagram_username = $dto->instagram_username;
        $person->telegram_username = $dto->telegram_username;
        $person->vk_url = $dto->vk_url;
        $person->facebook_url = $dto->facebook_url;
        $person->note = $dto->note;
        $person->created_at = Carbon::now();
    }

    /**
     * @param Person $person
     * @throws \Exception
     */
    public function delete(Person $person): void
    {
        $person->delete();
    }
}
