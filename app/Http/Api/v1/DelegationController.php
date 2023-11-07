<?php
declare(strict_types=1);

namespace App\Http\Api\v1;

use App\Domain\Delegation\DTO\DelegationDTO;
use App\Domain\Delegation\Enums\CountryCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\DelegationStoreRequest;
use App\Http\Resources\DelegationResource;
use Carbon\Carbon;
use Delegation as DelegationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

/**
 * @class  DelegationController
 * @package \App\Http\Api\v1\DelegationController
 */
class DelegationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function indexAction(): JsonResponse
    {
        return Response::success(
            DelegationResource::collection(DelegationService::fetchAll())
        );
    }

    /**
     * @param DelegationStoreRequest $request
     * @return JsonResponse
     */
    public function storeAction(DelegationStoreRequest $request): JsonResponse
    {
        return Response::success(
            new DelegationResource(DelegationService::create(new DelegationDTO(
                $request->get('worker_id'),
                Carbon::parse($request->get('start')),
                Carbon::parse($request->get('end')),
                CountryCodeEnum::from($request->get('country'))
            )))
        );
    }
}
