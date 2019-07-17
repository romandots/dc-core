<?php
/**
 * File: Student.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class Student
 *
 * @package App\Models
 * @package int $id
 * @package string $name
 * @package string $description
 * @package string $picture
 * @package string $status [potential|active|recent|former]
 * @package bool $display
 * @package int $person_id
 * @package \Carbon\Carbon $seen_at
 * @package \Carbon\Carbon $created_at
 * @package \Carbon\Carbon $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \App\Models\Person $person
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student role($roles, $guard = null)
 * @mixin \Eloquent
 */
class Student extends Model
{
    use HasRoles;

    public const TABLE = 'students';

    public const STATUS_POTENTIAL = 'potential';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_RECENT = 'recent';
    public const STATUS_FORMER = 'former';
    public const STATUSES = [
        self::STATUS_POTENTIAL,
        self::STATUS_ACTIVE,
        self::STATUS_RECENT,
        self::STATUS_FORMER
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Customer|null
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
