<?php
/**
 * File: ScheduleShowTest.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-24
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace Tests\Feature\Api\Schedule;

use App\Models\Schedule;
use App\Services\Permissions\SchedulesPermissions;
use Tests\TestCase;
use Tests\Traits\CreatesFakes;

/**
 * Class ScheduleShowTest
 * @package Tests\Feature\Api\Schedule
 */
class ScheduleShowTest extends TestCase
{
    use CreatesFakes;

    protected const URL = 'manager_api/v1/schedules';

    private const JSON_STRUCTURE = [
        'data' => [
            'id',
            'branch_id',
            'classroom_id',
            'course',
            'starts_at',
            'ends_at',
            'duration',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ]
    ];

    /**
     * @var Schedule
     */
    private $schedule;

    /**
     * @var string
     */
    private $url;

    public function setUp(): void
    {
        parent::setUp();
        $instructor = $this->createFakeInstructor();
        $course = $this->createFakeCourse(['instructor_id' => $instructor->id]);
        $this->schedule = $this->createFakeSchedule(['course_id' => $course->id]);
        $this->url = self::URL . '/' . $this->schedule->id;
    }

    public function testAccessDenied(): void
    {
        $this
            ->get($this->url)
            ->assertStatus(401);
    }

    public function testNoPermission(): void
    {
        $user = $this->createFakeUser();

        $this
            ->actingAs($user, 'api')
            ->get($this->url)
            ->assertStatus(403);
    }

    public function testSuccess(): void
    {
        $user = $this->createFakeManagerUser([], [
            SchedulesPermissions::READ_SCHEDULES
        ]);

        $this
            ->actingAs($user, 'api')
            ->get($this->url)
            ->assertOk()
            ->assertJsonStructure(self::JSON_STRUCTURE)
            ->assertJson([
                'data' => [
                    'id' => $this->schedule->id,
                    'branch_id' => $this->schedule->branch_id,
                    'classroom_id' => $this->schedule->classroom_id,
                    'starts_at' => $this->schedule->starts_at->toDateString(),
                    'ends_at' => $this->schedule->ends_at->toDateString(),
                    'duration' => $this->schedule->duration,
                    'monday' => $this->schedule->monday,
                    'tuesday' => $this->schedule->tuesday,
                    'wednesday' => $this->schedule->wednesday,
                    'thursday' => $this->schedule->thursday,
                    'friday' => $this->schedule->friday,
                    'saturday' => $this->schedule->saturday,
                    'sunday' => $this->schedule->sunday,
                ]
            ]);
    }
}