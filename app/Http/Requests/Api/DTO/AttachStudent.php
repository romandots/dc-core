<?php
/**
 * File: AttachStudent.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api\DTO;

/**
 * Class AttachStudent
 * @package App\Http\Requests\Api\DTO
 */
class AttachStudent
{
    /**
     * @var int
     */
    public $card_number;

    /**
     * @var int
     */
    public $person_id;

    /**
     * @var int
     */
    public $customer_id;
}
