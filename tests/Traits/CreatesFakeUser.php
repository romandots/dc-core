<?php
/**
 * File: CreatesFakeUser.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-20
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace Tests\Traits;

/**
 * Trait CreatesFakeUser
 * @package Tests\Traits
 */
trait CreatesFakeUser
{
    /**
     * @param array|null $attributes
     * @return \App\Models\User
     */
    private function createFakeUser(array $attributes = []): \App\Models\User
    {
        if (!isset($attributes['person_id'])) {
            $person = $this->createFakePerson();
            $attributes['person_id'] = $person->id;
        }

        return \factory(\App\Models\User::class)->create($attributes);
    }
}
