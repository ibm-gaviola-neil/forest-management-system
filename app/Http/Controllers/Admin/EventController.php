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
        $events = [];
        return view('Pages.Admin.events', compact('events'));
    }

    public function store(EventsRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['display_start_date'] = $this->formatDate($payload['display_start_date']);
        $payload['display_end_date'] = $this->formatDate($payload['display_end_date']);

        try {
            $event = Event::create($payload);
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('display_start_date','Server error, please try again.');
        }
    }
}
