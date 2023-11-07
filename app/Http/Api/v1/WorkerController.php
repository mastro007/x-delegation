<?php
declare(strict_types=1);

namespace App\Http\Api\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Worker as WorkerService;

/**
 * @class WorkerController
 * @package \App\Http\Api\v1\WorkerController
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
