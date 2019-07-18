<?php
/**
 * File: StudentRepository.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Repository;

use App\Http\Requests\Api\DTO\UpdateStudent;
use App\Models\Person;
use App\Models\Student;

/**
 * Class StudentRepository
 * @package App\Repository
 */
class StudentRepository
{
    /**
     * @var PersonRepository
     */
    protected $personRepository;

    /**
     * StudentRepository constructor.
     * @param PersonRepository $personRepository
     */
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * @param int $id
     * @return Student|null
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function find(int $id): ?Student
    {
        return Student::query()->findOrFail($id);
    }

    /**
     * @param Person $person
     * @param int|null $cardNumber
     * @return Student
     */
    public function create(Person $person, ?int $cardNumber = null): Student
    {
        $student = new Student;
        $student->person_id = $person->id;
        $student->name = "{$person->last_name} {$person->first_name}";
        $student->card_number = $cardNumber;
        $student->status = Student::STATUS_POTENTIAL;
        $student->save();

        return $student;
    }

    /**
     * @param Student $person
     * @param UpdateStudent $dto
     * @return Student
     */
    public function update(Student $person, UpdateStudent $dto): Student
    {
        $person->card_number = $dto->card_number;
        $person->save();

        return $person;
    }

    /**
     * @param Student $student
     * @throws \Exception
     */
    public function delete(Student $student): void
    {
        \DB::transaction(function () use ($student) {
            $person = $student->person;
            $student->person_id = null;
            $student->save();
            $this->personRepository->delete($person);
            $student->delete();
        });
    }
}
