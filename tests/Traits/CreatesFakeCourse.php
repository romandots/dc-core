<?php
/**
 * File: CreatesFakeCourse.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-23
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Course;

/**
 * Trait CreatesFakeCourse
 * @package Tests\Traits
 */
trait CreatesFakeCourse
{
    /**
     * @param array $attributes
     * @return Course
     */
    private function createFakeCourse(array $attributes = []): Course
    {
        $attributes['instructor_id'] = $attributes['instructor_id'] ?? $this->createFakeInstructor()->id;
        return \factory(Course::class)->create($attributes);
    }
}
