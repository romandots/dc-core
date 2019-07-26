<?php
/**
 * File: ScheduleController.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-24
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ScheduleOnDateRequest;
use App\Http\Requests\Api\StoreScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Repository\ScheduleRepository;
use App\Services\Schedule\ScheduleService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ScheduleController
 * @package App\Http\Controllers
 */
class ScheduleController extends Controller
{
    /**
     * @var ScheduleRepository
     */
    private $repository;

    /**
     * @var ScheduleService
     */
    private $service;

    /**
     * ScheduleController constructor.
     * @param ScheduleRepository $repository
     */
    public function __construct(ScheduleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param StoreScheduleRequest $request
     * @return ScheduleResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function store(StoreScheduleRequest $request): ScheduleResource
    {
        $schedule = $this->repository->create($request->getDto());
        $schedule->load('course');

        return new ScheduleResource($schedule);
    }

    /**
     * @param int $id
     * @return ScheduleResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(int $id): ScheduleResource
    {
        $schedule = $this->repository->find($id);
        $schedule->load('course');

        return new ScheduleResource($schedule);
    }

    /**
     * @param StoreScheduleRequest $request
     * @param int $id
     * @return ScheduleResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(StoreScheduleRequest $request, int $id): ScheduleResource
    {
        $schedule = $this->repository->find($id);
        $this->repository->update($schedule, $request->getDto());
        $schedule->load('course');

        return new ScheduleResource($schedule);
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function destroy(int $id): void
    {
        $schedule = $this->repository->find($id);
        $this->repository->delete($schedule);
    }

    /**
     * @param ScheduleOnDateRequest $request
     * @return AnonymousResourceCollection
     */
    public function onDate(ScheduleOnDateRequest $request): AnonymousResourceCollection
    {
        $schedules = $this->repository->getSchedulesForDate($request->getDto());
        $schedules->load('course');

        return ScheduleResource::collection($schedules);
    }
}
