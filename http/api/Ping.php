<?php

namespace Voilaah\MallApi\Http\Api;

use Response;
use Illuminate\Routing\Controller;

/**
 * Class PingController.
 *
 * @author Christophe Vidal <chris@voilaah.com>
 */
class Ping extends Controller
{
    /**
     * Responds with a status for heath check.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Response::json(
            [
            'status' => 'ok',
            'timestamp' => \Carbon\Carbon::now(),
        ]);
    }
}
