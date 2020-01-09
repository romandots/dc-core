<?php
/**
 * File: CourseResource.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-23
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Genre;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CourseResource
 * @package App\Http\Resources
 * @mixin \App\Models\Course
 */
class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'status_label' => \trans('course.' . $this->status),
            'summary' => $this->summary,
            'description' => $this->description,
            'picture' => $this->picture,
            'picture_thumb' => $this->picture_thumb,
            'age_restrictions_from' => $this->age_restrictions_from,
            'age_restrictions_to' => $this->age_restrictions_to,
            'instructor' => $this->whenLoaded('instructor', function () {
                return new InstructorResource($this->instructor);
            }),
            'starts_at' => $this->starts_at ? $this->starts_at->toDateString() : null,
            'ends_at' => $this->ends_at ? $this->ends_at->toDateString() : null,
            'genres' => $this->tagsWithType(Genre::class)->pluck('name')->all(),
        ];
    }
}
