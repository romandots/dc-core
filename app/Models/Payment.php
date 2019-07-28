<?php
/**
 * File: Payment.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-28
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 *
 * @package App\Models
 * @property string $id
 * @property string $name
 * @property int $amount
 * @property string $type [manual|automatic]
 * @property string $transfer_type [cash|card|online|internal|code]
 * @property string $status [pending|expired|confirmed|canceled]
 * @property string $object_type [App\Models\Lesson|App\Models\Visit]
 * @property string|null $object_id
 * @property string $account_id
 * @property string|null $related_id
 * @property string|null $external_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $confirmed_at
 * @property \Carbon\Carbon|null $canceled_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|Account $account
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|User $user
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|Payment|null $related_payment
 * @property-read \Illuminate\Database\Eloquent\Relations\MorphTo|Lesson|Visit $object
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment query()
 * @mixin \Eloquent
 */
class Payment extends Model
{
    public const TABLE = 'payments';

    public const TYPE_MANUAL = 'manual';
    public const TYPE_AUTOMATIC = 'automatic';
    public const TYPES = [
        self::TYPE_MANUAL,
        self::TYPE_AUTOMATIC
    ];

    public const TRANSFER_TYPE_CASH = 'cash';
    public const TRANSFER_TYPE_CARD = 'card';
    public const TRANSFER_TYPE_ONLINE = 'online';
    public const TRANSFER_TYPE_INTERNAL = 'internal';
    public const TRANSFER_TYPE_CODE = 'code';
    public const TRANSFER_TYPES = [
        self::TRANSFER_TYPE_CASH,
        self::TRANSFER_TYPE_CARD,
        self::TRANSFER_TYPE_ONLINE,
        self::TRANSFER_TYPE_INTERNAL,
        self::TRANSFER_TYPE_CODE
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_EXPIRED,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELED,
    ];

    public const OBJECT_TYPES = [
        Visit::class,
        Lesson::class
    ];

    protected $table = self::TABLE;

    protected $casts = [
        'expired_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Account
     */
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|self|null
     */
    public function related_payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|Lesson|Visit
     */
    public function object(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
