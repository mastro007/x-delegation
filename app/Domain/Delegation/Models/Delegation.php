<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Models;

use App\Domain\Delegation\DB\Factories\DelegationFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Delegation
 * @property string $worker_id
 * @property Carbon $start
 * @property Carbon $end
 * @property \App\Domain\Delegation\Enums\CountryCodeEnum $country
 * @property mixed|string $currency
 * @property integer $amount_due
 * @package \App\Domain\Delegation\Models\Delegation
 */
class Delegation extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function worker(): HasMany
    {
        return $this->hasMany(Worker::class, 'worker_id');
    }

    /**
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return DelegationFactory::new();
    }
}
