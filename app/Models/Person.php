<?php
/**
 * File: Person.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */
declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Notifiable;
use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Person
 * @package App\Models
 * @property string $id
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
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Instructor $instructor
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person query()
 * @mixin \Eloquent
 * @todo phone_verified_at, email_verified_at
 * @todo referrer_id
 * @todo source_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereFacebookUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereInstagramUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person wherePatronymicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person wherePictureThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereTelegramUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereVkUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Person whereVkUrl($value)
 */
class Person extends Model
{
    use UsesUuid;
    use Notifiable;

    public const TABLE = 'people';

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const GENDER = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

    protected $table = self::TABLE;

    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
    ];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|User|null
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }
}
