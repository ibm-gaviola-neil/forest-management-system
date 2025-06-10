<table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
    <thead>
        <tr>
            <th class="">Blood Unit Serial Number</th>
            <th>Patien Name</th>
            <th>Requestor</th>
            <th>Blood Type</th>
            <th>Date of Crossmatch</th>
            <th>Time of Crossmatch</th>
            <th>Release Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reportData as $history)
            <tr>
                <td>
                    <button class="btn btn-default serial_number" value="{{ $history->blood_bag_id }}" style="text-transform: capitalize;">
                        {{ $history->blood_bag_id}}
                    </span>
                </td>
                <td>
                    <h6 class="mb-0 text-primary" style="text-transform: capitalize">
                        {{ $history->last_name. ' ' .$history->first_name  }}
                    </h6>
                    <span>{{ $history->email }}</span><br>
                    <span>{{ $history->contact_number }}</span>
                </td>
                <td>
                    <span style="text-transform: capitalize;">
                        {{ $history->requestor}}
                    </span>
                </td>
                <td>
                    <span style="text-transform: capitalize;">
                        {{ $history->blood_type}}
                    </span>
                </td>
                <td>{{ $history->date_of_crossmatch}}</td>
                <td>
                    {{ $history->time_of_crossmatch }}
                </td>
                <td>{{ $history->release_date }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No Data</td>
            </tr>
        @endforelse
    </tbody>
</table>

@include('Pages.Admin.blood-issuance.info')
@push('scripts')
    <script type="module" src="{{ asset('assets/js/features/blood-issuance-history.js') }}"></script>
@endpush