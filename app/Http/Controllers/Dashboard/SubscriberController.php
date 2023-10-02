<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SubscribeRequest;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('subscriber index')) {
            abort(403);
        }
        $subscribers = Subscriber::paginate(10);

        return response([
            'subscriber' => $subscribers,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscribeRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('subscriber store')) {
            abort(403);
        }
        $subscriber = Subscriber::updateOrCreate(
            ['email' => $request->email],
            ['active' => true]
        );

        return response([
            'subscriber' => $subscriber,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscriber $subscriber)
    {
        if (!auth()->user()->hasPermissionTo('subscriber show')) {
            abort(403);
        }
        return response([
            'subscriber' => $subscriber,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscribeRequest $request, Subscriber $subscriber)
    {
        if (!auth()->user()->hasPermissionTo('subscriber update')) {
            abort(403);
        }
        $data = $request->validated();
        $subscriber->update($data);

        return response([
            'subscriber' => $subscriber->refresh(),
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        if (!auth()->user()->hasPermissionTo('subscriber destroy')) {
            abort(403);
        }
        $subscriber->delete();

        return response([
            'message' => 'subscriber deleted',
        ], 200);
    }

    public function subscribe(Subscriber $subscriber)
    {
        $subscriber->update([
            'active' => 1,
        ]);

        return response([
            'message' => 'You subscribe News',
        ], 202);
    }

    public function unsubscribe(Subscriber $subscriber)
    {
        $subscriber->update([
            'active' => 0,
        ]);

        return response([
            'message' => 'You unsubscribe News',
        ], 202);
    }
}