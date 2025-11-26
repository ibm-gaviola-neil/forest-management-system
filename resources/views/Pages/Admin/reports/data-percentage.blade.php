<div class="row clearfix">
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Blood Issuance Percentage <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $percentage['numberOfBloodIssued'] ?? '0%' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Blood Donation Percentage <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $percentage['numbeOfBloodDonated'] ?? '0%' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <h6>Blood Donation Data</h6>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">A+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['a_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">A-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['a_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">AB+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['ab_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">AB-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['ab_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">B+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['b_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">B-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['b_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">0+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['o_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">O-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_types['a_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <h6>Blood Issuance Data</h6>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">A+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['a_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">A-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['a_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">AB+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['ab_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">AB-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['ab_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">B+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['b_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">B-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['b_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">0+</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['o_plus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                    <div class="ml-4">
                        <span>Total Type <strong class="badge badge-danger text-black">O-</strong> <span stye="font-size: 14px; font-weight: bolder;"></span></span>
                        <h4 class="mb-0 font-weight-medium">{{ $blood_issuance_count['a_minus'] ?? null }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>