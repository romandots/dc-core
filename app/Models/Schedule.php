<?php
/**
 * File: Schedule.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-24
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 *
 * @package App
 * @property string $id
 * @property string $weekday
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon $ends_at
 * @property string $branch_id
 * @property string $classroom_id
 * @property string|null $course_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|Course|null $course
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|Classroom|null $classroom
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereWednesday($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    use UsesUuid;

    public const TABLE = 'schedules';

    public const MONDAY = 1;
    public const TUESDAY = 2;
    public const WEDNESDAY = 3;
    public const THURSDAY = 4;
    public const FRIDAY = 5;
    public const SATURDAY = 6;
    public const SUNDAY = 7;

    public const WEEKDAYS = [
        self::MONDAY,
        self::TUESDAY,
        self::WEDNESDAY,
        self::THURSDAY,
        self::FRIDAY,
        self::SATURDAY,
        self::SUNDAY,
    ];

    protected $table = self::TABLE;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Course|null
     */
    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Branch|null
     */
    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Classroom|null
     */
    public function classroom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
