<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use \Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    public function fetch() {
        $channels = Channel::all();

        return response()->json($channels, Response::HTTP_OK);
    }
}
