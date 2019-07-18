<?php
/**
 * File: StoreStudent.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Requests\Api\DTO;

/**
 * Class StoreStudent
 * @package App\Http\Requests\Api\DTO
 */
class StoreStudent
{
    /**
     * @var int
     */
    public $card_number;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $patronymic_name;

    /**
     * @var \Carbon\Carbon
     */
    public $birth_date;

    /**
     * @var string
     */
    public $gender;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $picture;

    /**
     * @var string
     */
    public $picture_thumb;

    /**
     * @var string
     */
    public $instagram_username;

    /**
     * @var string
     */
    public $telegram_username;

    /**
     * @var string
     */
    public $vk_uid;

    /**
     * @var string
     */
    public $vk_url;

    /**
     * @var string
     */
    public $facebook_uid;

    /**
     * @var string
     */
    public $facebook_url;

    /**
     * @var string
     */
    public $note;
}
