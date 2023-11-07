<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Models;

use App\Domain\Delegation\DB\Factories\WorkerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property string $company
 * @property string $id
 * @class Worker
 * @package \App\Domain\Delegation\Models\Worker
 * @method static create(array $array)
 */
class Worker extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function delegations(): BelongsTo
    {
        return $this->belongsTo(Delegation::class, 'worker_id');
    }

    protected static function newFactory(): Factory
    {
        return WorkerFactory::new();
    }
}
