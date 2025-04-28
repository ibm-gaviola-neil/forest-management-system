<?php

namespace App\Http\Repositories;

use App\Models\Event;
use Carbon\Carbon;

class EventRepository {
    public function getEvents(){
        $events = Event::where('display_start_date', '<=', Carbon::now())
            ->where('display_end_date', '>=', Carbon::now())
            ->orderBy('created_at','desc')
            ->get();

        return $events;
    }
}