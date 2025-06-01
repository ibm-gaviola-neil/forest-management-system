<div class="">
    <div class="row clearfix">
        <div class="col-6 col-md-4 col-xl-3">
            <div class="card">
                <div class="body ribbon">
                    <div class="ribbon-box green">{{ $peapleCounts['donors'] ?? 0 }}</div>
                    <a href="/donors" class="my_sort_cut text-muted">
                        <i class="icon-users"></i>
                        <span>Donors</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="card">
                <div class="body ribbon">
                    <div class="ribbon-box green">{{ $peapleCounts['users'] ?? 0 }}</div>
                    @if (auth()->user()->role === 'general_admin' || auth()->user()->role === 'admin')  
                        <a href="/users" class="my_sort_cut text-muted">
                            <i class="icon-users"></i>
                            <span>Users</span>
                        </a>
                    @else
                        <a href="#" class="my_sort_cut text-muted">
                            <i class="icon-users"></i>
                            <span>Users</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="card">
                <div class="body ribbon">
                    <div class="ribbon-box orange">{{ $peapleCounts['events'] ?? 0 }}</div>
                    <a href="/events" class="my_sort_cut text-muted">
                        <i class="icon-calendar"></i>
                        <span>Events</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <div class="card">
                <div class="body">
                    <a href="/reports" class="my_sort_cut text-muted">
                        <i class="icon-credit-card"></i>
                        <span>Reports</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>