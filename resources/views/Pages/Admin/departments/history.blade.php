<div class="modal fade emails-modal-lg" tabindex="-1" role="dialog" id="info-modal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Department Head Histories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table custom-table" id="dept-head">
                        <thead>
                            <tr>
                                <th>Department Head</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody id="dept-table">

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