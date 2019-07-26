<?php
/**
 * File: Lesson.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-26
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lesson
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int|null $course_id
 * @property int|null $schedule_id
 * @property int|null $instructor_id
 * @property int|null $controller_id
 * @property int $branch_id
 * @property int $classroom_id
 * @property string $type [lesson | event | rent]
 * @property string $status [booked | ongoing | passed | canceled | closed]
 * @property \Carbon\Carbon $starts_at
 * @property \Carbon\Carbon $ends_at
 * @property \Carbon\Carbon|null $closed_at
 * @property \Carbon\Carbon|null $canceled_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string $
 * @property-read \App\Models\User $controller
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Instructor $instructor
 * @property-read \App\Models\Schedule $schedule
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lesson newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lesson onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lesson query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lesson withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lesson withoutTrashed()
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use SoftDeletes;

    public const TABLE = 'lessons';

    public const TYPE_LESSON = 'lesson';
    public const TYPE_EVENT = 'event';
    public const TYPE_RENT = 'rent';

    public const TYPES = [
        self::TYPE_LESSON,
        self::TYPE_EVENT,
        self::TYPE_RENT,
    ];

    public const STATUS_BOOKED = 'booked';
    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_PASSED = 'passed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_CLOSED = 'closed';

    public const STATUSES = [
        self::STATUS_BOOKED,
        self::STATUS_ONGOING,
        self::STATUS_PASSED,
        self::STATUS_CANCELED,
        self::STATUS_CLOSED
    ];

    protected $table = self::TABLE;

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'closed_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Instructor|null
     */
    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Instructor::class)->with('person');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Schedule|null
     */
    public function schedule(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Course|null
     */
    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User|null
     */
    public function controller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->with('person');
    }
}