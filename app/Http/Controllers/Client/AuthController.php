<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Domains\NotificationDomain;
use App\Http\Domains\TraitAdmin;
use App\Http\Requests\AccountSetupRequest;
use App\Http\Requests\DonorRequest;
use App\Http\Services\NotificationService;
use App\Http\Services\SettingService;
use App\Models\City;
use App\Models\Donor;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use TraitAdmin;
    private $systemSettings;
    private $notificationService;

    public function __construct(SettingService $settings, NotificationService $notificationService)
    {
        $this->systemSettings = $settings;
        $this->notificationService = $notificationService;
    }

    public function index(){
        $data = $this->systemSettings->getSettings();
        return view('index', $data);
    }

    public function create(){
        $settings = $this->systemSettings->getSettings();

        if(!$settings['is_enable']){
            return redirect('/');
        }

        $data['provinces'] = Province::orderBy('provDesc', 'ASC')->get();
        return view('register', $data);
    }

    public function store(DonorRequest $request)
    {
        $payload = $request->validated();

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;
        return response()->json([
            'status' => 200,
            'data' => $payload
        ]);
    }

    public function confirm(Request $request){
        $payload = $request->except('_token', 'patient');

        $province_name = Province::where('provCode', $request->province)->first();
        $city_name = City::where('citymunCode', $request->city)->first();
        $payload['province'] = $province_name->provDesc;
        $payload['city'] = $city_name->citymunDesc;

        $save = DB::transaction(function() use ($payload){
            $isSave = Donor::create($payload);
            return $isSave;
        });

        if(!$save){
            return response()->json([
                'status' => 500,
                'data' => $payload,
                'message' => 'Unable to save Patient!'
            ]); 
        }

        return response()->json([
            'status' => 200,
            'data' => $payload,
            'donor' => $save
        ]);
    }

    public function setup(Donor $donor)
    {
        if ($donor->valid_id_image !== null || $donor->id_type !== null) {
            return redirect('/register');
        }

        $data['donor'] = $donor;
        return view('account-setup', $data);
    }

    public function setupStore(AccountSetupRequest $request, Donor $donor)
    {
        $payload = $request->validated();
        try {
            if($request->hasFile('valid_id_image')){
                $logoImageFile = $request->file('valid_id_image')->store('images', 'public');
                $payload['valid_id_image'] = $logoImageFile;
            }
    
            DB::transaction(function() use ($payload, $donor) {
                $donor->update([
                    'valid_id_image' => $payload['valid_id_image'],
                    'id_type' => $payload['id_type'],
                    'temp_p' => $payload['password']
                ]);
    
                User::create([
                    'donor_id' => $donor->id,
                    'last_name' => $donor->last_name,
                    'first_name' => $donor->first_name,
                    'username' => $payload['username'],
                    'password' => Hash::make($payload['password']),
                    'account_status' => 0,
                    'role' => 'donor',
                    'status' => 'active',
                    'email' => $donor->email
                ]);

                $this->notificationService->saveNotification([
                    'type' => NotificationDomain::DONOR_REGISTRATION,
                    'message' => 'New donor registered: ' . $donor->first_name . ' ' . $donor->last_name,
                    'related_id' => $donor->id,
                    'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::DONOR_REGISTRATION],
                    'is_read' => false,
                    'created_by' => null,
                ]);
            });

            return response([
                'message' => 'success'
            ],200);
        } catch (\Throwable $th) {
            return response([
                'error' => $th->getMessage()
            ],500);
        }

        
    }

    public function login(\App\Http\Requests\LoginRequest $request){
        $request->validated();
        $checkUser = User::where('username', $request['username'])->first();

        $auth = $request->only('username', 'password');

        if($checkUser->status !== 'active'){
            return redirect()->back()->withErrors(['password'=> 'Account not found!']); 
        }

        if(Auth::attempt($auth)){
            if(auth()->user()->role === 'donor'){
                return redirect('/donor-page');
            }
            return redirect('/admin');
        }

        return redirect()->back()->withErrors(['password'=> 'Wrong Credentials']);
    }

    public function user(){
        $user = Auth::user();

        return response()->json([
            'user' => $user,
        ]);
    }

    public function profile(){
        $user_id = auth()->user()->id;
        $data['user_data'] = User::where('id', $user_id)->first();
        $data['donor'] = $donor = Donor::where('id', auth()->user()->donor_id)->first();
        return view('Pages.Admin.profile.index', $data);
    }

    public function logout(){
        Auth::logout();

        return response()->json([
            'status' => 1
        ]);
    }
}
