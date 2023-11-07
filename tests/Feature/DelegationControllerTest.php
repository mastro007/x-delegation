<?php

namespace Tests\Feature;


use App\Domain\Delegation\Api\Requests\DelegationStoreRequest;
use App\Domain\Delegation\Enums\CountryCodeEnum;
use App\Domain\Delegation\Exceptions\DelegationException;
use App\Domain\Delegation\Models\Delegation;
use App\Domain\Delegation\Models\Worker;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;
use Tests\TestCase;

class DelegationControllerTest extends TestCase
{

    use RefreshDatabase;
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_store_delegation(): void
    {
        $worker = Worker::factory()->create();
        $payload = [
            'worker_id' => $worker->id,
            'start' => Carbon::today()->toDateTimeString(),
            'end' => Carbon::today()->addDays(7)->toDateTimeString(),
            'country' => CountryCodeEnum::PL->value
        ];

        $response = $this->postJson(route('api.delegations.store'), $payload);

        $response->assertSuccessful();
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'start',
                'end',
                'country',
                'amount_due',
                'currency'
            ]
        ]);
    }

    public function test_can_date_end_after_validation_working()
    {
        $worker = Worker::factory()->create();

        $payload = [
            'start' => Carbon::now()->toDateTimeString(),
            'end' => Carbon::now()->subDay()->toDateTimeString(),
            'worker_id' => $worker->id,
            'country' => CountryCodeEnum::PL->value
        ];

        $response = $this->postJson(route('api.delegations.store'), $payload);
        $response->assertStatus(422);
        $response->assertJsonPath('message', DelegationStoreRequest::capture()->messages()['end.after']);
    }

    public function test_can_validation_require_worker()
    {

        $payload = [

            'start' => Carbon::today()->toDateTimeString(),
            'end' => Carbon::today()->addDays(7)->toDateTimeString(),
            'country' => CountryCodeEnum::PL->value
        ];

        $response = $this->postJson(route('api.delegations.store'), $payload);
        $response->assertStatus(422);
        $response->assertJsonPath('message', DelegationStoreRequest::capture()->messages()['worker_id.required']);
    }

    public function test_can_validation_detect_invalid_country_code()
    {
        $worker = Worker::factory()->create();
        $payload = [
            'worker_id' => $worker->id,
            'start' => Carbon::today()->toDateTimeString(),
            'end' => Carbon::today()->addDays(7)->toDateTimeString(),
            'country' => 'ZN'
        ];

        $response = $this->postJson(route('api.delegations.store'), $payload);
        $response->assertStatus(422);
        $response->assertJsonPath('message', DelegationStoreRequest::capture()->messages()['country.Illuminate\Validation\Rules\Enum']);
    }

    public function test_can_date_start_after_or_equal_validation_working()
    {
        $worker = Worker::factory()->create();

        $payload = [
            'start' => Carbon::now()->subDay()->toDateTimeString(),
            'end' => Carbon::now()->addDays(5)->toDateTimeString(),
            'worker_id' => $worker->id,
            'country' => CountryCodeEnum::PL->value
        ];

        $response = $this->postJson(route('api.delegations.store'), $payload);
        $response->assertStatus(422);
        $response->assertJsonPath('message', DelegationStoreRequest::capture()->messages()['start.after_or_equal']);
    }

    public function test_can_worker_delegate_while_has_another_delegation()
    {
        $worker = Worker::factory()->create();
        $payload1 = [
            'worker_id' => $worker->id,
            'start' => Carbon::now()->toDateTimeString(),
            'end' => Carbon::now()->addDays(7)->toDateTimeString(),
            'country' => CountryCodeEnum::PL->value
        ];

        $delegation1 = $this->postJson(route('api.delegations.store'), $payload1);
        $delegation1->assertSuccessful();
        $delegation2 = $this->postJson(route('api.delegations.store'), $payload1);
        $delegation2->assertStatus(419);
        $delegation2->assertJsonPath('message', DelegationException::workerAlreadyDelegated()->getMessage());


    }

    public function test_can_fetch_delegations()
    {
        Delegation::factory(10)->create();
        $response = $this->getJson(route('api.delegations.index'));
        $response->assertSuccessful();
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }


}
