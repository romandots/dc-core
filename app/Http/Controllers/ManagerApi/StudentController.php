<?php
/**
 * File: StudentController.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Controllers\ManagerApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerApi\StoreStudentFromPersonRequest;
use App\Http\Requests\ManagerApi\StoreStudentRequest;
use App\Http\Requests\ManagerApi\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Repository\PersonRepository;
use App\Repository\StudentRepository;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    private PersonRepository $personRepository;

    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository, PersonRepository $personRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->personRepository = $personRepository;
    }

    public function store(StoreStudentRequest $request): StudentResource
    {
        /** @var Student $student */
        $student = DB::transaction(function () use ($request) {
            $person = $this->personRepository->createFromDto($request->getPersonDto());
            return $this->studentRepository->createFromPerson($person, $request->getStudentDto());
        });
        $student->load('customer', 'person');

        return new StudentResource($student);
    }

    public function storeFromPerson(StoreStudentFromPersonRequest $request): StudentResource
    {
        /** @var Student $student */
        $student = DB::transaction(function () use ($request) {
            $person = $this->personRepository->find($request->getPersonDto()->person_id);
            return $this->studentRepository->createFromPerson($person, $request->getStudentDto());
        });
        $student->load('customer', 'person');

        return new StudentResource($student);
    }

    /**
     * @param string $id
     * @return StudentResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(string $id): StudentResource
    {
        $student = $this->studentRepository->find($id);
        $student->load('customer', 'person');

        return new StudentResource($student);
    }

    /**
     * @param string $id
     * @param UpdateStudentRequest $request
     * @return StudentResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(string $id, UpdateStudentRequest $request): StudentResource
    {
        $student = $this->studentRepository->find($id);
        $this->studentRepository->update($student, $request->getDto());
        $student->load('customer', 'person');

        return new StudentResource($student);
    }

    /**
     * @param string $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function destroy(string $id): void
    {
        $student = $this->studentRepository->find($id);
        $this->studentRepository->delete($student);
    }
}
