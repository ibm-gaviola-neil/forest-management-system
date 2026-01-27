<?php

namespace App\Http\Controllers;

use App\Http\Domains\NotificationDomain;
use App\Http\Requests\ChainsawRequest;
use App\Http\Services\ChainsawService;
use App\Http\Services\NotificationService;
use App\Models\ChainsawRequest as ModelsChainsawRequest;
use App\Models\ChainsawRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ChainsawController extends Controller
{
    public function index() 
    {
        return view('Pages.Applicant.chainsaw-registration.index');
    }

    public function list(ChainsawService $chainsawService, Request $request) 
    {
        $role = auth()->user()->role;
        $data = $chainsawService->getChainsawData($role, $request);

        return response()->json($data);
    }

    public function create()
    {
        return view('Pages.Applicant.chainsaw-registration.create');
    }

    public function store(ChainsawRequest $request, ChainsawService $chainsawService, NotificationService $notificationService)
    {
        DB::beginTransaction();
        
        try {
            $payload = $request->validated();
            
            // Add request metadata for logging
            Log::info('Chainsaw Registration creation started', [
                'user_id' => auth()->id(),
                'tree_id' => $payload['tree_id'] ?? null
            ]);
            
            $chainsaw = $chainsawService->saveChainsaw($request->getDataExceptDocuments(), $request);
            
            DB::commit();
            
            // Log successful creation
            Log::info('Chainsaw registration created successfully', [
                'permit_id' => $chainsaw->id,
                'user_id' => auth()->id()
            ]);

            if($chainsaw) {
                $notificationService->saveNotification([
                    'type' => NotificationDomain::CHAINSAW,
                    'message' => 'New Pending Registration of chainsaw registration by ' . auth()->user()->last_name . ', ' . auth()->user()->first_name,
                    'related_id' => $chainsaw->id,
                    'related_table' => NotificationDomain::RELATED_TABLES[NotificationDomain::CHAINSAW],
                    'is_read' => false,
                    'created_by' => auth()->user()->id,
                ]);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Chainsaw registration request submitted successfully.',
                'data' => [
                    'permit' => [
                        'id' => $chainsaw->id,
                        'status' => $chainsaw->status_label,
                        'status_class' => $chainsaw->status_badge_class,
                        'tree_info' => [
                            'id' => $cuttingPermit->tree->treeId ?? null,
                            'type' => $cuttingPermit->tree->treeType ?? null
                        ],
                        'submitted_at' => $chainsaw->created_at->format('M d, Y H:i A'),
                        'document_name' => $chainsaw->document_original_name
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
            
            Log::warning('File upload error in Chainsaw registration', [
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
            
            Log::error('Database error in Chainsaw registration creation', [
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
                'message' => $e->getMessage(),
                'error_code' => 'CP_' . time() // Error tracking code
            ], 500);
        }
    }

    public function show(ModelsChainsawRequest $chainsaw)
    {
        $data['chainsaw'] = $chainsaw;
        $data['requirements'] = $chainsaw->requirements;
        return view('Pages.Applicant.chainsaw-registration.view', $data);
    }

    public function edit(ModelsChainsawRequest $chainsaw)
    {
        if($chainsaw->status !== 0) {
            abort(404);
        }

        $data['chainsaw'] = $chainsaw;
        $data['editFlg'] = true;
        return view('Pages.Applicant.chainsaw-registration.edit', $data);
    }

    public function update(ModelsChainsawRequest $chainsaw, ChainsawRequest $request, ChainsawService $chainsawService)
    {
        DB::beginTransaction();
        
        try {
            $payload = $request->validated();
            
            // Add request metadata for logging
            Log::info('Chainsaw Registration creation started', [
                'user_id' => auth()->id(),
                'tree_id' => $payload['tree_id'] ?? null
            ]);
            
            $chainsawService->editChainsaw($request->getDataExceptDocuments(), $request, $chainsaw);
            
            DB::commit();
            
            // Log successful creation
            Log::info('Chainsaw registration updated successfully', [
                'permit_id' => $chainsaw->id,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Chainsaw registration request submitted successfully.',
                'data' => [
                    'permit' => [
                        'id' => $chainsaw->id,
                        'status' => $chainsaw->status_label,
                        'status_class' => $chainsaw->status_badge_class,
                        'tree_info' => [
                            'id' => $cuttingPermit->tree->treeId ?? null,
                            'type' => $cuttingPermit->tree->treeType ?? null
                        ],
                        'submitted_at' => $chainsaw->created_at->format('M d, Y H:i A'),
                        'document_name' => $chainsaw->document_original_name
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
            
            Log::warning('File upload error in Chainsaw registration', [
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
            
            Log::error('Database error in Chainsaw registration creation', [
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
                'message' => $e->getMessage(),
                'error_code' => 'CP_' . time() // Error tracking code
            ], 500);
        }
    }

    public function cancel(ModelsChainsawRequest $chainsaw)
    {
        if ($chainsaw->status === 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chainsaw registration already cancelled, please reload the page!',
            ], 200);
        }

        try {
            $chainsaw->status = 3;
            $chainsaw->save();

            return response()->json([
                'status' => 200,
                'message' => 'Chainsaw data cancelled successfully.',
                'data' => $chainsaw
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel chainsaw registration. Please try again.',
                'log' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteFile(ChainsawRequirement $requirement)
    {
        $chainsaw = ModelsChainsawRequest::where('id', $requirement->chainsaw_request_id)->first();

        if ($chainsaw->status !== 0) {
            return redirect()->back()->with('error', 'Unable to delete this requirement!'); 
        }

        $requirement->delete();
        return redirect()->back();
    }
}
