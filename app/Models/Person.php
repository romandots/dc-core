<?php
/**
 * File: Person.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 *
 * @package App\Models
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Instructor $instructor
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person query()
 * @mixin \Eloquent
 */
class Person extends Model
{
    public const TABLE = 'people';

    protected $table = self::TABLE;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Student|null
     */
    public function student(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Customer|null
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|Instructor|null
     */
    public function instructor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Instructor::class);
    }
}
