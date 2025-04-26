<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\TraitAdmin;
use App\Http\Requests\EventsRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use TraitAdmin;
    public function index(){
        $events = Event::orderBy('created_at', 'desc')->get();
        return view('Pages.Admin.events', compact('events'));
    }

    public function store(EventsRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['display_start_date'] = $this->formatDate($payload['display_start_date']);
        $payload['display_end_date'] = $this->formatDate($payload['display_end_date']);
        try {
            $events = Event::create($payload);
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
