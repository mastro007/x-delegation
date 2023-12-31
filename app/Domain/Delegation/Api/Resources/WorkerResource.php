<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @class WorkerResource
 * @package \App\Domain\Delegation\Api\Resources\WorkerResource
 * @property string $id
 * @property string $company
 */
class WorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company' => $this->company
        ];
    }
}
