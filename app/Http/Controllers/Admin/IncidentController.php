<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncidentRequest;
use App\Http\Services\IncidentService;
use App\Models\CuttingPermit;
use App\Models\Incident;
use App\Models\IncidentAttachment;
use App\Models\Tree;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class IncidentController extends Controller
{

    private $incidentService;

    public function __construct(IncidentService $incidentService)
    {
       $this->incidentService = $incidentService;
    }
    /**
     * Display a listing of incidents
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['pageTitle'] = 'Incident Reports';
        $data['pageSubTitle'] = 'Manage and respond to reported forest violations and incidents';
        return view('Pages.Admin.incidents.index', $data);
    }

    public function list(Request $request) 
    {
        $role = auth()->user()->role;
        $data = $this->incidentService->getIncidentData($role, $request);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new incident
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get staff members for the assignment dropdown
        $staffMembers = [
            [
                'id' => 'denr',
                'name' => 'DENR'
            ]
        ];
        $trees = Tree::where('status', 1)->orderBy('treeId')->get();
        $permits = CuttingPermit::where('status', 1)->orderBy('permit_id')->get();

        // Set default values or any other data needed for the form
        $incident = new Incident();
        $incident->status = 1; // Default status: New/Unverified
        $pageTitle = 'Report Incidents';
        $pageSubTitle = 'Report Incidents';

        // Return the view with the necessary data
        return view('Pages.Admin.incidents.create', compact('incident', 'staffMembers', 'trees', 'permits', 'pageTitle', 'pageSubTitle'));
    }

    public function store(IncidentRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $payload = $request->validated();
            
            // Add request metadata for logging
            Log::info('Incident creation started', [
                'user_id' => auth()->id(),
                'tree_id' => $payload['tree_id'] ?? null
            ]);
            
            $incident = $this->incidentService->saveIncident($request->getDataExceptDocuments(), $request);
            
            DB::commit();
            
            // Log successful creation
            Log::info('Cutting permit created successfully', [
                'permit_id' => $incident->id,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Cutting permit request submitted successfully.',
                'data' => [
                    'permit' => [
                        'id' => $incident->id,
                        'incident_info' => [
                            $incident
                        ],
                        'submitted_at' => $incident->created_at->format('M d, Y H:i A'),
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
                'error_code' => 'CP_' . time() . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Incident $incident)
    {
        $data['staffMembers'] = [
            [
                'id' => 'denr',
                'name' => 'DENR'
            ]
        ];
        $data['trees'] = Tree::where('status', 1)->orderBy('treeId')->get();
        $data['permits'] = CuttingPermit::where('status', 1)->orderBy('permit_id')->get();
        $data['incident'] = $incident;
        $data['pageTitle'] = 'Report Incidents';
        $data['pageSubTitle'] = 'Report Incidents';
        return view('Pages.Admin.incidents.edit', $data);
    }

    public function update(IncidentRequest $request, Incident $incident)
    {
        DB::beginTransaction();
        
        try {
            $payload = $request->validated();
            
            // Add request metadata for logging
            Log::info('Incident creation started', [
                'user_id' => auth()->id(),
                'tree_id' => $payload['tree_id'] ?? null
            ]);
            
            $incident = $this->incidentService->editIncident($request->getDataExceptDocuments(), $request, $incident);
            
            DB::commit();
            
            // Log successful creation
            Log::info('Cutting permit created successfully', [
                'permit_id' => $incident->id,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Cutting permit request submitted successfully.',
                'data' => [
                    'permit' => [
                        'id' => $incident->id,
                        'incident_info' => [
                            $incident
                        ],
                        'submitted_at' => $incident->created_at->format('M d, Y H:i A'),
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
                'error_code' => 'CP_' . time() . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get incidents data for DataTable
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIncidentsData(Request $request)
    {
        // This will be implemented with actual data fetching later
        // For now, we'll focus on the frontend

        return response()->json([
            'data' => [],
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
        ]);
    }

    /**
     * Export incidents data
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportIncidents(Request $request)
    {
        // This will be implemented with the export functionality later

        return response()->json(['message' => 'Export functionality will be implemented']);
    }

    /**
     * Display the specified incident
     *
     * @param Incident $incident
     * @return \Illuminate\View\View
     */
    public function show(Incident $incident)
    {
        $data['pageTitle'] = 'Incident Report Information';
        $data['subPageTitle'] = '';
        $data['incident'] = $incident;
        $data['requirements'] = IncidentAttachment::where('incident_id', $incident->id)->get();
        $data['tree'] = Tree::find($incident->related_tree_id);
        $data['permit'] = CuttingPermit::find($incident->related_permit_id);
        return view('Pages.Admin.incidents.view', $data);
    }

    /**
     * Update the incident status
     *
     * @param Request $request
     * @param Incident $incident
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Incident $incident)
    {
        // This will be implemented with actual status updating later

        return back()->with('success', 'Status updated successfully');
    }

    public function deleteAttachment(IncidentAttachment $attachment)
    {
        $attachment->delete();
        return back()->with('success', 'Attachment deleted successfully');
    }
}
