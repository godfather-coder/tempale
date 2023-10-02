<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ContactMessageRequest;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! auth()->user()->hasPermissionTo('message destroy')) {
            abort(403);
        }
        $messages = ContactMessage::paginate(10);

        return response([
            'data' => $messages,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactMessageRequest $request)
    {
        if (! auth()->user()->hasPermissionTo('message store')) {
            abort(403);
        }
        $message = ContactMessage::create($request->validated());

        return response([
            'data' => $message,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $contactMessage)
    {
        if (! auth()->user()->hasPermissionTo('message show')) {
            abort(403);
        }

        return response([
            'subscriber' => $contactMessage,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactMessageRequest $request, ContactMessage $contactMessage)
    {
        if (! auth()->user()->hasPermissionTo('message update')) {
            abort(403);
        }
        $contactMessage->update($request->validated());

        return response([
            'data' => $contactMessage->refresh(),
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMessage $contactMessage)
    {
        if (! auth()->user()->hasPermissionTo('message destroy')) {
            abort(403);
        }
        $contactMessage->delete();

        return response([
            'message' => 'ContactMessage deleted',
        ], 200);
    }
}
