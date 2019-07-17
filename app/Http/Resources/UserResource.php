<?php
/**
 * File: UserResource.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : '',
            'approved_at' => $this->approved_at ? $this->approved_at->toDateTimeString() : '',
            'seen_at' => $this->seen_at ? $this->seen_at->toDateTimeString() : '',
        ];
    }
}
