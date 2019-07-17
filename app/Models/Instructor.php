<?php
/**
 * File: Instructor.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class Instructor
 *
 * @package App\Models
 * @package int $id
 * @package string $name
 * @package int $card_number
 * @package string $status [hired|freelance|fired]
 * @package int $person_id
 * @package int $customer_id
 * @package \Carbon\Carbon $seen_at
 * @package \Carbon\Carbon $created_at
 * @package \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \App\Models\Person $person
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instructor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instructor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instructor permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instructor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instructor role($roles, $guard = null)
 * @mixin \Eloquent
 */
class Instructor extends Model
{
    use HasRoles;

    public const TABLE = 'instructors';

    public const STATUS_HIRED = 'hired';
    public const STATUS_FREELANCE = 'freelance';
    public const STATUS_FIRED = 'fired';
    public const STATUSES = [
        self::STATUS_HIRED,
        self::STATUS_FREELANCE,
        self::STATUS_FIRED
    ];

    protected $table = self::TABLE;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Person|null
     */
    public function person(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
