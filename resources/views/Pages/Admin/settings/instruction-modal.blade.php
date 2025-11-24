<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">2-Step Verifications Google Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <label for="" style="font-weight: 500">Step 1: Go to your <span class="font-bold">Google Account</span>.</label>
                </div>
                <div class="mb-2">
                    <label for="" style="font-weight: 500">Step 2: Find <span class="font-bold">Security and Sign in</span>.</label>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step security.jpg')}}" alt="">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="" style="font-weight: 500">Step 3: On <span class="font-bold">2-Verification</span>, if not yet setup, setup the <span class="font-bold">Google Prompt and the Phone Number</span>.</label>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 1.jpg')}}" alt="">
                    </div>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 2.jpg')}}" alt="">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="" style="font-weight: 500">Step 4: Search on <span class="font-bold">App Passwords</span>.</label>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 3.jpg')}}" alt="">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="" style="font-weight: 500">Step 5: On App Passwords add your <span class="font-bold">App Name</span>, then click create.</label>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 4.jpg')}}" alt="">
                    </div>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 5.jpg')}}" alt="">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="" style="font-weight: 500">Step 6: After click create, the <span class="font-bold">App Password</span> will pop up. <span class="font-important">Copy your App Password</span></label>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 6.jpg')}}" alt="">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="" style="font-weight: 500">Step 7: Go to system page of the <span class="font-bold">Blood Registry System</span> and copy the app password. <span class="font-important">Make sure to remove spaces.</span> Then save the changes.</label>
                    <div class="img-container">
                        <img src="{{asset('/assets/images/steps/step 7.jpg')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .font-bold {
        font-weight: 700;
    }
    .img-container {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .img-container img {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .font-important {
        color: red;
        font-weight: 700;
    }
</style>