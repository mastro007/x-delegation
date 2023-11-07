<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Api\Controllers\v1;


use App\Domain\Delegation\Api\Resources\WorkerResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Worker as WorkerService;

/**
 * @class WorkerController
 * @package \App\Domain\Delegation\Api\Controllers\v1\WorkerController
 */
class WorkerController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return Response::success(new WorkerResource(WorkerService::create()));
    }
}
