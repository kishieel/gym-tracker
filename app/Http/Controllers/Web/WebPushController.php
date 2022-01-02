<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebPushRequest;
use App\Models\User;
use Illuminate\Http\Request;

class WebPushController extends Controller
{
    /**
     * Subscribe push notifications.
     *
     * @param \App\Http\Requests\WebPushRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(WebPushRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->updatePushSubscription(
            $request->input('endpoint'),
            $request->input('keys.p256dh'),
            $request->input('keys.auth'),
        );

        return response()->json(['success' => true]);
    }


    /**
     * Unsubscribe push notifications.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribe(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->deletePushSubscription(
            $request->input('endpoint'),
        );

        return response()->json(['success' => true]);
    }
}
