<?php

namespace App\Http\Controllers;

use App\Events\StreamAnswer;
use App\Events\StreamOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebrtcStreamingController extends Controller
{

    public function index()
    {
        Log::info('qq'. Auth::id());
        Log::info(request());
        return view('video-broadcast', ['type' => 'broadcaster', 'id' => Auth::id()]);
    }

    public function consumer(Request $request, $streamId)
    {
        Log::info('ww'. Auth::id());
        return view('video-broadcast', ['type' => 'consumer', 'streamId' => $streamId, 'id' => Auth::id()]);
    }

    public function makeStreamOffer(Request $request)
    {
        Log::info('ff'. Auth::id());
        $data['broadcaster'] = $request->broadcaster;
        $data['receiver'] = $request->receiver;
        $data['offer'] = $request->offer;

        event(new StreamOffer($data));
    }

    public function makeStreamAnswer(Request $request)
    {
        Log::info('makeStreamAnswer:');
        Log::info($request);
        $data['broadcaster'] = $request->broadcaster;
        $data['answer'] = $request->answer;
        event(new StreamAnswer($data));
    }
}