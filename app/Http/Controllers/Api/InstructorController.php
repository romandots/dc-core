<?php
/**
 * File: InstructorController.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-19
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AttachInstructorRequest;
use App\Http\Requests\Api\StoreInstructorRequest;
use App\Http\Requests\Api\UpdateInstructorRequest;
use App\Http\Resources\InstructorResource;
use App\Models\Instructor;
use App\Repository\InstructorRepository;
use App\Repository\PersonRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class InstructorController
 * @package App\Http\Controllers\Api
 */
class InstructorController extends Controller
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * @var InstructorRepository
     */
    private $instructorRepository;

    /**
     * InstructorController constructor.
     * @param InstructorRepository $instructorRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(InstructorRepository $instructorRepository, PersonRepository $personRepository)
    {
        $this->instructorRepository = $instructorRepository;
        $this->personRepository = $personRepository;
    }

    /**
     * @param StoreInstructorRequest $request
     * @return InstructorResource
     */
    public function store(StoreInstructorRequest $request): InstructorResource
    {
        /** @var Instructor $instructor */
        $instructor = DB::transaction(function () use ($request) {
            $person = $this->personRepository->create($request->getPersonDto());
            return $this->instructorRepository->create($person, $request->getInstructorDto());
        });
        $instructor->load('person');

        return new InstructorResource($instructor);
    }

    /**
     * @param AttachInstructorRequest $request
     * @return InstructorResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function createFromPerson(AttachInstructorRequest $request): InstructorResource
    {
        $instructor = $request->getDto();
        $person = $this->personRepository->find($request->person_id);
        $instructor = $this->instructorRepository->create($person, $instructor);
        $instructor->load('person');

        return new InstructorResource($instructor);
    }

    /**
     * @param int $id
     * @return InstructorResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): InstructorResource
    {
        $instructor = $this->instructorRepository->find($id);
        $instructor->load('person');

        return new InstructorResource($instructor);
    }

    /**
     * @param int $id
     * @param UpdateInstructorRequest $request
     * @return InstructorResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(int $id, UpdateInstructorRequest $request): InstructorResource
    {
        $instructor = $this->instructorRepository->find($id);
        $this->instructorRepository->update($instructor, $request->getDto());
        $instructor->load('person');

        return new InstructorResource($instructor);
    }

    /**
     * @param int $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function destroy(int $id): void
    {
        $instructor = $this->instructorRepository->find($id);
        $this->instructorRepository->delete($instructor);
    }
}
