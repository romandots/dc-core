<?php
/**
 * File: LessonsOnDate.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-26
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api\DTO;

/**
 * Class LessonsOnDate
 * @package App\Http\Requests\Api\DTO
 */
class LessonsOnDate
{
    /**
     * @var \Carbon\Carbon
     */
    public $date;

    /**
     * @var int|null
     */
    public $branch_id;

    /**
     * @var int|null
     */
    public $classroom_id;

    /**
     * @var int|null
     */
    public $course_id;
}