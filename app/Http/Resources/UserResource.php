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
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'person' => $this->whenLoaded('person', function () {
                return new PersonResource($this->person);
            }),
            'is_instructor' => $this->whenLoaded('instructor', function () {
                return null !== $this->instructor;
            }),
            'is_student' => $this->whenLoaded('student', function () {
                return null !== $this->student;
            }),
            'is_customer' => $this->whenLoaded('customer', function () {
                return null !== $this->customer;
            }),
            'roles' => $this->getRoleNames(),
            'permissions' => $this->getPermissionNames(),
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ?  $this->updated_at->toDateTimeString() : null,
            'approved_at' => $this->approved_at ? $this->approved_at->toDateTimeString() : null,
            'seen_at' => $this->seen_at ? $this->seen_at->toDateTimeString() : null,
            'status' => $this->status,
            'status_label' => \trans('user.status.'.$this->status),
        ];
    }
}
