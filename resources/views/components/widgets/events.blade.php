
    
<div class="col-lg-6 col-md-12">
    <div class="card" >
        <div class="body" style="max-height: 480px; overflow-y: scroll;">
            <div class="header">
                <h2>Events</h2>
            </div>
            <ul class="timeline timeline-split">

                @forelse ($events as $event)
                    <li class="timeline-item">
                        <div class="timeline-info">
                            <span>{{ \Carbon\Carbon::parse($event->display_start_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h3 class="timeline-title" style="text-transform: capitalize">{{ $event->title }}</h3>
                            <p>{{ $event->content }}</p>
                        </div>
                    </li>
                @empty
                    <li>No Active Events</li>
                @endforelse
              
            </ul>
        </div>
    </div>
</div>