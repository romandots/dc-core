<?php
/**
 * File: ContractResource.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ContractResource
 * @package App\Http\Resources
 * @mixin \App\Models\Contract
 */
class ContractResource extends JsonResource
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
            'serial' => $this->serial,
            'number' => $this->number,
            'branch_id' => $this->branch_id,
            'status' => $this->status,
            'status_label' => \trans($this->status),
            'created_at' => $this->terminated_at->toDateTimeString(),
            'signed_at' => $this->signed_at->toDateTimeString(),
            'terminated_at' => $this->terminated_at->toDateTimeString(),
        ];
    }
}
