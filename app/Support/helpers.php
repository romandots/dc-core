<?php
/**
 * File: helpers.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-18
 * Copyright (c) 2019
 */

declare(strict_types=1);

if (!function_exists('phone_format')) {
    /**
     * Format phone number to mask format
     * @param string $phone
     * @return string
     */
    function phone_format(string $phone): string {
        $digits = \preg_replace('/\D/', '', $phone);
        return \preg_replace('/^([78]?)(\d{3})(\d{3})(\d{2})(\d+)/', '+7-\2-\3-\4-\5', $digits);
    }
}
