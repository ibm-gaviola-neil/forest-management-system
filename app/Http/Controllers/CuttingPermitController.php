<?php

namespace App\Http\Controllers;

use App\Http\Domains\NotificationDomain;
use App\Http\Requests\CuttingPermitRequest;
use App\Http\Services\CuttingPermitService;
use App\Http\Services\NotificationService;
use App\Models\CuttingPermit;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CuttingPermitController extends Controller
{
    private $cuttingPermitService;

    public function __construct(CuttingPermitService $cuttingPermitService)
    {
        $this->cuttingPermitService = $cuttingPermitService;
    }

    public function index()
    {
        return view('Pages.Applicant.cutting-permit.index');
    }

    public function list(Request $request) 
    {
        $role = auth()->user()->role;
        $data = $this->cuttingPermitService->getCuttingPermitData($role, $request);

        return response()->json($data);
    }

    public function create()
    {
        $data['selectableData'] = $this->cuttingPermitService->getSelectableData();
        return view('Pages.Applicant.cutting-permit.create', $data);
    }

    public function store(CuttingPermitRequest $request, NotificationService $notificationService)
    {
        DB::beginTransaction();
        
        try {
            $payload = $request->validated();
            
            // Add request metadata for logging
            Log::info('Cutting permit creation started', [
                'user_id' => auth()->id(),
                'tree_id' => $payload['tree_id'] ?? null
            ]);
            
            $cuttingPermit = $this->cuttingPermitService->saveCuttingPermit($request->getDataExceptDocuments(), $request);
            
            DB::commit();
            
            // Log successful creation
            Log::info('Cutting permit created successfully', [
                'permit_id' => $cuttingPermit->id,
                'user_id' => auth()->id()
            ]);

            $notificationService->saveNotification([
                'type' => NotificationDomain::PERMIT,
                'message' => 'New Pending for review of cutting permit application by ' . auth()->user()->last_name . ', ' . auth()->user()->first_name,
                'related_id' => $cuttingPermit->id,
                'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::PERMIT],
                'is_read' => false,
                'created_by' => auth()->user()->id,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Cutting permit request submitted successfully.',
                'data' => [
                    'permit' => [
                        'id' => $cuttingPermit->id,
                        'status' => $cuttingPermit->status_label,
                        'status_class' => $cuttingPermit->status_badge_class,
                        'tree_info' => [
                            'id' => $cuttingPermit->tree->treeId ?? null,
                            'type' => $cuttingPermit->tree->treeType ?? null
                        ],
                        'submitted_at' => $cuttingPermit->created_at->format('M d, Y H:i A'),
                        'document_name' => $cuttingPermit->document_original_name
                    ]
                ]
            ], 201);
            
        } catch (ValidationException $e) {
            DB::rollBack();
            
            return response()->json([
                'status' => 'validation_error',
                'message' => 'Please check the form data and try again.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (FileException $e) {
            DB::rollBack();
            
            Log::warning('File upload error in cutting permit', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'file_error',
                'message' => 'Document upload failed. Please check your file and try again.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 400);
            
        } catch (QueryException $e) {
            DB::rollBack();
            
            Log::error('Database error in cutting permit creation', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'sql' => $e->getSql() ?? null
            ]);
            
            // Check for specific database constraints
            if (str_contains($e->getMessage(), 'foreign key constraint')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid tree selection. Please refresh the page and try again.'
                ], 400);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred.'.$e->getMessage()
            ], 500);
            
        } catch (\Throwable $e) {
            DB::rollBack();
            
            Log::critical('Critical error in cutting permit creation', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload ?? null
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'A system error occurred. Our team has been notified.',
                'error_code' => 'CP_' . time() // Error tracking code
            ], 500);
        }
    }

    public function show(CuttingPermit $cuttingPermit) 
    {
        $data['cutting_permit'] = $cuttingPermit;
        $data['requirements'] = $cuttingPermit->requirements;
        return view('Pages.Applicant.cutting-permit.view', $data);
    }

    public function cancel(CuttingPermit $cuttingPermit)
    {
        try {
            $this->cuttingPermitService->cancelCuttingPermit($cuttingPermit);
            return response()->json([
                'status' => 200,
                'message' => 'Cutting permit application data cancelled successfully.',
                'data' => $cuttingPermit
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed. Please try again.',
                'log' => $th->getMessage()
            ], 500);
        }
    }
}
