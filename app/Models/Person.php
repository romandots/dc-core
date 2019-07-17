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
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $patronymic_name
 * @property \Carbon\Carbon $birth_date
 * @property string $gender [male|female]
 * @property string $phone
 * @property string $email
 * @property string $picture
 * @property string $picture_thumb
 * @property string $instagram_username
 * @property string $telegram_username
 * @property string $vk_uid
 * @property string $vk_url
 * @property string $facebook_uid
 * @property string $facebook_url
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
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

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const GENDER = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

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
