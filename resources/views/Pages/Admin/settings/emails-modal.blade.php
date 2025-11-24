<div class="modal fade emails-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Email History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover js-basic-example dataTable custom-table">
                        <thead>
                            <tr>
                                <th>Updated By</th>
                                <th>Email Address</th>
                                <th>Email App Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emails as $email)
                                <tr>
                                    <td>{{ $email->last_name }} {{$email->first_name}}</td>
                                    <td>{{ $email->email_address }}</td>
                                    <td>{{ $email->email_password }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-table {
        border: 1px solid #dee2e6 !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }
    .custom-table th {
        font-weight: bold !important;
        background-color: #f8f9fa !important;
        border-bottom: 2px solid #dee2e6 !important;
    }
    .custom-table td, .custom-table th {
        border: 1px solid #dee2e6 !important;
    }
</style>