<?php
/**
 * File: LessonVisit.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-26
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api\DTO;

/**
 * Class LessonVisit
 * @package App\Http\Requests\Api\DTO
 */
class LessonVisit
{
    /**
     * @var string
     */
    public $student_id;

    /**
     * @var string
     */
    public $lesson_id;

    /**
     * @var string|null
     */
    public $promocode_id;
}
