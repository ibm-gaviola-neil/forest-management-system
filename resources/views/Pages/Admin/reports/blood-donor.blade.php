<table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
    <thead>
        <tr>
            <th class="">Blood Unit Serial Number </th>
            <th class="">Blood Type</th>
            <th class="">Expiration Date</th>
            <th>Address</th>
            <th>Donated By</th>
            <th>Donation Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reportData as $inventory)
            <tr>
                <td>{{ $inventory->blood_bag_id }}</td>
                <td style="font-weight: bold" class="text-danger">
                    {{ $inventory->blood_type }}
                </td>
                <td>{{ $inventory->expiration_date }}</td>
                <td>{{ $inventory->province . ', ' . $inventory->city .', '. $inventory->barangay  }}</td>
                <td>
                    <h6 class="mb-0" style="text-transform: capitalize">
                        <a href="/donors/{{ $inventory->donor_id }}/view" class="text-primary">
                            {{ $inventory->donor_name}}
                        </a>
                    </h6>
                    <span>{{ $inventory->email }}</span><br>
                    <span>{{ $inventory->contact_number }}</span>
                </td>
                <td>{{ $inventory->date_process  }}</td>
            </tr>
        @empty
            
        @endforelse
    </tbody>
</table>