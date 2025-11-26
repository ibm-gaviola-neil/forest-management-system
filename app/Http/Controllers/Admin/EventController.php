<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\NotificationDomain;
use App\Http\Domains\TraitAdmin;
use App\Http\Requests\EventsRequest;
use App\Http\Services\NotificationService;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use TraitAdmin;
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }


    public function index(Request $request){
        $events = Event::orderBy('created_at', 'desc')->get();

        if (isset($request->event_id)) {
            $events = Event::where('id', $request->event_id)->orderBy('created_at', 'desc')->get();
        }

        return view('Pages.Admin.events', compact('events'));
    }

    public function store(EventsRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['display_start_date'] = $this->formatDate($payload['display_start_date']);
        $payload['display_end_date'] = $this->formatDate($payload['display_end_date']);

        if($request->has('image')){
            $payload['image'] = $request->file('image')->store('images', 'public');
        } else {
            $payload['image'] = null;
        }

        try {
            $events = Event::create($payload);
            $this->notificationService->saveNotification([
                'type' => NotificationDomain::EVENT,
                'message' => 'New event created: ' . $events->title,
                'related_id' => $events->id,
                'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::EVENT],
                'is_read' => false,
                'created_by' => auth()->user()->id,
            ]);
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'display_start_date' => 'Server error, please try again.'
            ]);
        }
    }

    public function show(Event $event){
        return response()->json($event);
    }

    public function update(Event $event, EventsRequest $request){
        $payload = $request->validated();
        $payload['display_start_date'] = $this->formatDate($payload['display_start_date']);
        $payload['display_end_date'] = $this->formatDate($payload['display_end_date']);

        $save = $event->update($payload);

        if(!$save){
            return response()->json([
                'status' => 500,
                'message' => 'Unable to edit this edit, please try again'
            ]);
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Event edited successfuly'
        ]);
    }

    public function delete(Event $event){
        $delete = $event->delete();

        if(!$delete){
            return response()->json([
                'status' => 500,
                'message' => 'Unable to delete event.'
            ]); 
        }

        return response()->json([
            'status' => 200
        ]);
    }
}
