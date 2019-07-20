<?php
/**
 * File: Contract.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contract
 * @package App\Models
 * @property int $id
 * @property string $serial
 * @property string $number
 * @property int $branch_id
 * @property int customer_id
 * @property string $status [pending|signed|terminated]
 * @property \Carbon\Carbon $signed_at
 * @property \Carbon\Carbon $terminated_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contract query()
 * @mixin \Eloquent
 */
class Contract extends Model
{
    public const TABLE = 'contracts';

    public const STATUS_PENDING = 'pending';
    public const STATUS_SIGNED = 'signed';
    public const STATUS_TERMINATED = 'terminated';
    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_SIGNED,
        self::STATUS_TERMINATED
    ];

    protected $table = self::TABLE;

    protected $fillable = [];
}
