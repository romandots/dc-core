<?php
/**
 * File: CreatesFakeAccount.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-30
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace Tests\Traits;

use App\Models\Account;

/**
 * Trait CreatesFakeAccount
 * @package Tests\Unit
 */
trait CreatesFakeAccount
{
    /**
     * @param array|null $attributes
     * @return Account
     */
    private function createFakeAccount(?array $attributes = []): Account
    {
        return \factory(Account::class)->create($attributes);
    }
}
