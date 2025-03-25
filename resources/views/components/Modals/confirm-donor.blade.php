<div class="modal bd-example-modal-lg fade" id="confirm-donor" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-lg" role="document" id="confirm-donor-form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Donor Information</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">

                        <input type="hidden" id="department_id">

                        <div class="form-group">
                            <label for="" class="form-label">Department Name <span
                                    class="text-danger">*</span></label>
                            <input id="edit-department_name" type="text" name="department_name" class="form-control @error('department_name') parsley-error @enderror" placeholder="Department Name *">
                            <span id="department_name_Error" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="" class="form-label">Department Head <span
                                    class="text-danger">*</span></label>
                            <input id="edit-department_head" type="text" name="department_head" class="form-control @error('department_head') parsley-error @enderror" placeholder="Department Name">
                            <span id="department_head_Error" class="error"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="" class="form-label">Department Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="edit-department_email" type="email" name="email" class="form-control @error('email') parsley-error @enderror" placeholder="Email">
                            <span id="email_Error" class="error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="" class="form-label">Department Contact Number <span
                                    class="text-danger">*</span></label>
                            <input id="edit-department_number" type="number" name="contact_number" class="form-control @error('contact_number') parsley-error @enderror" placeholder="Department Contact Number">
                            <span id="contact_number_Error" class="error"></span>
                        </div>
                    </div>
                </div> --}}

                <table class="table spacing5">
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Name: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_name">Neil Bryan Gaviola</th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Email: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_email"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Contact Number: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_contact"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Address: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_address"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Gender: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_gender"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Civil Status: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_status"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Birth Date: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_date"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Blood Type: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_type"></th>
                    </tr>
                </table>

                <span id="error-message"></span>

            </div>
            <div class="modal-footer">
                <button type="button" id="edit-close-button" class="btn btn-round btn-default"
                    data-dismiss="modal">Cancel</button>
                <button type="submit" id="confirm-donor-a" class="btn btn-round btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
