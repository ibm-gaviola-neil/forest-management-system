<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped table-hover js-basic-example dataTable table-custom spacing8">
                    <thead>
                        <tr>
                            <th class="">Blood Unit Serial Number</th>
                            <th>Department Name</th>
                            <th>Requestor</th>
                            <th>Blood Type</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($offices as $history)
                            <tr id="user-{{ $history->patient_id }}">
                                <td>
                                    <button class="btn btn-default serial_number" value="{{ $history->blood_bag_id }}" style="text-transform: capitalize;">
                                        {{ $history->blood_bag_id}}
                                    </span>
                                </td>
                                <td>
                                    <h6 class="mb-0 text-primary" style="text-transform: capitalize">
                                        {{ $history->department_name  }}
                                    </h6>
                                    <span>{{ $history->email }}</span><br>
                                    <span>{{ $history->department_head }}</span>
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
                                <td>{{ $history->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>