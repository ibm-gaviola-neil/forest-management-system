<div class="modal bd-example-modal-lg fade" id="confirm-donate" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-lg modal-dialog-centered" role="document" id="confirm-donor-form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Donation Information</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table spacing5">
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Blood Bag ID: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="blood_bag"></th>
                    </tr>
                    {{-- <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">QNTY: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="qnty"></th>
                    </tr> --}}
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Donation Type: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="type"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Donation Date: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="don_date"></th>
                    </tr>
                    {{-- <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Entry Date: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="entry_date"></th>
                    </tr> --}}
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Processed By: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="processed"></th>
                    </tr>
                    {{-- <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Blood Type: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="td_type"></th>
                    </tr> --}}
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Venue: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="venue"></th>
                    </tr>
                    <tr style="">
                        <th style="font-weight: 500; border-bottom: 1px solid #D3D3D3;">Expiration Date: </th>
                        <th style="font-weight:500; border-bottom: 1px solid #D3D3D3; text-transform: uppercase;" id="expiration"></th>
                    </tr>
                </table>

                <span id="error-message"></span>

            </div>
            <div class="modal-footer">
                <button type="button" id="edit-close-button" class="btn btn-round btn-default"
                    data-dismiss="modal">Close</button>
                {{-- <button type="submit" id="confirm-donor-a" class="btn btn-round btn-primary">Submit</button> --}}
            </div>
        </div>
    </form>
</div>
