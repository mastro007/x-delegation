<?php
declare(strict_types=1);

namespace App\Domain\Delegation\DTO;

use Spatie\LaravelData\Data as DTO;

class WorkerDTO extends DTO
{
    public function __construct(
        readonly ?string $id,
        readonly ?string $company
    )
    {
    }
}
