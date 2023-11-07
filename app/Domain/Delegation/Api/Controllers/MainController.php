<?php
declare(strict_types=1);

namespace App\Domain\Delegation\Api\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class MainController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return Response::success(
            [
                'message' => 'standby',
                'version' => 'v0.0.1',
                'server_time' => Carbon::now()->toDateTimeString()
            ]
        );
    }
}
