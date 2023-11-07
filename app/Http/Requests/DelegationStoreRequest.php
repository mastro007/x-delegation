<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Domain\Delegation\Enums\CountryCodeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @class DelegationStoreRequest
 * @package \App\Http\Requests\DelegationStoreRequest
 */
class DelegationStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'worker_id' => ['required', 'string', 'size:32', 'exists:workers,id'],
            'start' => ['required', 'date_format:Y-m-d H:i:s', 'after_or_equal:today'],
            'end' => ['required', 'date_format:Y-m-d H:i:s', 'after:start'],
            'country' => ['required', new Enum(CountryCodeEnum::class)]
        ];
    }

    /**
     * @return string[]
     * @todo Wrzucić do tłumaczeń
     */
    public function messages(): array
    {
        return [
            'worker_id.required' => 'Wymagany identyfikator pracownika',
            'worker_id.exists' => 'Nie znaleziono pracownika',
            'start.required' => 'Wymagana data początkowa',
            'start.date_format' => 'Nieprawidłowy format daty początkowej',
            'start.after_or_equal' => 'Data początkowa nie może być późniejsza od daty dzisiejszej',
            'end.required' => 'Wymagana data końcowa',
            'end.date_format' => 'Nieprawidłowy format daty końcowej',
            'end.after' => 'Data końcowa musi być późniejsza od daty początkowej',
            'country.required' => 'Wymagany kod kraju',
            'country.Illuminate\Validation\Rules\Enum' => 'Nieprawidłowy kod kraju'

        ];
    }
}
