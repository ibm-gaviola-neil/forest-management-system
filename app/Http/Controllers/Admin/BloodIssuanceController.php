<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\TraitAdmin;
use App\Http\Requests\BloodIssuanceRequest;
use App\Http\Services\BloodIssuanceService;
use App\Models\BloodIssuance;
use App\Models\DonationHistory;
use App\Models\Patient;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloodIssuanceController extends Controller
{
    use TraitAdmin;
    protected $bloodIssuanceService;

    public function __construct(BloodIssuanceService $bloodIssuanceService){
        $this->bloodIssuanceService = $bloodIssuanceService;
    }

    public function index(Request $request){
        $provinces = Province::orderBy('provDesc', 'ASC')->get();
        return view('Pages.Admin.blood-issuance.index', [
            'provinces'=> $provinces,
            'staffs' =>   User::where('role', 'staff')->orderBy('last_name', 'ASC')->get(),
            'patients' => Patient::orderBy('last_name')->get(),
            'serial_numbers' => $this->bloodIssuanceService->getBloodBagData($request)
        ]);
    }

    public function history(){
        $data['histories'] = $this->bloodIssuanceService->bloodIssuanceHistory();
        return view('Pages.Admin.blood-issuance.history', $data);
    }

    public function store(BloodIssuanceRequest $request){
        $data = $this->bloodIssuanceService->setConfirmBloodIssuance($request->validated());
        return response()->json([
            'status' => 200,
            'payload' => $data
        ]);
    }

    public function getSerialNumber(Request $request){
        return response()->json($this->bloodIssuanceService->getBloodBagData($request));  
    }

    public function confirm(BloodIssuanceRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['expiration_date'] = $this->formatDate($request['expiration_date']);
        $payload['date_of_crossmatch'] = $this->formatDate($request['date_of_crossmatch']);

        $save = DB::transaction(function ()  use(&$payload) {

            DonationHistory::where('blood_bag_id', $payload['blood_bag_id'])->update([
                'count' => 0
            ]);

            return BloodIssuance::create($payload);
        });


        if(!$save){
            return response()->json([
                'status' => 500,
                'payload' => $payload
            ]);
        }

        return response()->json([
            'status' => 200,
            'payload' => $request
        ]);
    }
}
